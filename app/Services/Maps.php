<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Maps
{
	private string $api_key;
	private string $base_url = "https://routes.googleapis.com/directions/v2:computeRoutes";

	public function __construct()
	{
		$this->api_key = env('GOOGLE_MAPS_API_KEY');
	}



   /**
	 * Geocode an address to latitude and longitude.
	 *
	 * @param string $address
	 * @return array|null
	 */
	private function geocodeAddress(string $address): ?array
	{
		$response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
			'address' => $address,
			'key' => $this->api_key,
		]);

		if ($response->successful()) {
			$data = $response->json();
			if (!empty($data['results'])) {
				$location = $data['results'][0]['geometry']['location'];
				return [
					'latitude' => $location['lat'],
					'longitude' => $location['lng'],
				];
			}
		}

		return null;
	}

	/**
	 * Get optimized route and generate Google Maps URL.
	 *
	 * @param string $origin
     * The origin address.
     *
	 * @param array $places
     * The destination places.
     *
     * @param string $transportation
     * The transportation mode.
     *
	 * @return string
     * The Google Maps URL for the optimized route.
     *
	 * @throws \Exception
	 */
    public function getRoutes(string $origin, array $places, string $transportation): string
    {

        $transportation = $this->getTransportationMode($transportation);
        // Validate input
        if (empty($places)) {
            throw new \Exception('At least one destination place is required.');
        }

        // Geocode origin and places
        $originCoords = $this->geocodeAddress($origin);
        if (!$originCoords) {
            throw new \Exception('Origin address could not be geocoded.');
        }

        $placesCoords = [];
        foreach ($places as $index => $place) {
            $coords = $this->geocodeAddress($place);
            if ($coords) {
                $placesCoords[] = $coords;
            } else {
                throw new \Exception("Address '{$place}' could not be geocoded.");
            }
        }

        // If there's only one place, no optimization needed
        if (count($places) <= 1) {
            $orderedPlaces = [$origin, $places[0]];
            return $this->generateMapsUrl($orderedPlaces);
        }

        // Construct the request payload
        $payload = [
            'origin' => [
                'location' => [
                    'latLng' => [
                        'latitude' => $originCoords['latitude'],
                        'longitude' => $originCoords['longitude'],
                    ],
                ],
            ],
            'destination' => [
                'location' => [
                    'latLng' => [
                        'latitude' => end($placesCoords)['latitude'],
                        'longitude' => end($placesCoords)['longitude'],
                    ],
                ],
            ],
            'travelMode' => 'DRIVE',
            'intermediates' => count($placesCoords) > 1
                ? array_map(function ($place) {
                    return [
                        'location' => [
                            'latLng'=> [
                                'latitude' => $place['latitude'],
                                'longitude' => $place['longitude'],
                            ],
                        ],
                    ];
                }, array_slice($placesCoords, 0, -1))
                : [],
            'optimizeWaypointOrder' => false,
        ];

        // Define the fields to be returned in the response
        $fieldMask = 'routes.optimizedIntermediateWaypointIndex,routes.distanceMeters';

        // Add retry mechanism
        $maxRetries = 3;
        $attempts = 0;
        $lastResponse = null;

        while ($attempts < $maxRetries) {
            try {
                // Send the request to the Routes API
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Goog-Api-Key' => $this->api_key,
                    'X-Goog-FieldMask' => $fieldMask,
                ])->timeout(10)->post('https://routes.googleapis.com/directions/v2:computeRoutes', $payload);

                $lastResponse = $response;

                if ($response->successful()) {
                    $data = $response->json();

                    // Check if optimization data exists
                    if (isset($data['routes'][0]['optimizedIntermediateWaypointIndex'])) {
                        $optimizedOrder = $data['routes'][0]['optimizedIntermediateWaypointIndex'];

                        // Reorder places based on optimized order
                        $orderedPlaces = [$origin]; // Start with origin
                        foreach ($optimizedOrder as $index) {
                            if ($index < 0 || $index >= count($places)) {
                                Log::warning('Invalid index in optimized order', ['index' => $index, 'places_count' => count($places)]);
                                continue;
                            }
                            $orderedPlaces[] = $places[$index]; // Add places in optimized order
                        }
                        $orderedPlaces[] = end($places); // End with final destination

                        // Generate Google Maps URL
                        return $this->generateMapsUrl($orderedPlaces);
                    } else {
                        // Fallback: If no optimization data, use original order
                        Log::warning('Google API did not return optimized waypoint order. Using original order.',
                            ['response' => $response->json(), 'attempt' => $attempts + 1]);

                        // Use original order as fallback
                        $orderedPlaces = array_merge([$origin], $places);
                        return $this->generateMapsUrl($orderedPlaces);
                    }
                } else {
                    $error = $response->body();
                    Log::error('Error from Google Routes API', [
                        'status' => $response->status(),
                        'error' => $error,
                        'attempt' => $attempts + 1
                    ]);

                    // Check if we should retry based on status code
                    if (in_array($response->status(), [429, 500, 502, 503, 504])) {
                        $attempts++;
                        // Exponential backoff
                        if ($attempts < $maxRetries) {
                            sleep(pow(2, $attempts));
                            continue;
                        }
                    } else {
                        // Don't retry for client errors
                        break;
                    }
                }
            } catch (\Exception $e) {
                Log::error('Exception during route calculation', [
                    'exception' => $e->getMessage(),
                    'attempt' => $attempts + 1
                ]);
                $attempts++;
                if ($attempts < $maxRetries) {
                    sleep(pow(2, $attempts));
                    continue;
                }
            }
        }

        // If we've exhausted retries or got a non-retryable error
        if ($lastResponse) {
            throw new \Exception('Error fetching routes after ' . $attempts . ' attempts: ' . $lastResponse->body());
        } else {
            throw new \Exception('Error fetching routes: Could not contact Google API after ' . $attempts . ' attempts');
        }
    }

	/**
	 * Generate a Google Maps URL for the optimized route.
	 *
	 * @param array $orderedPlaces
	 * @return string
	 */
	private function generateMapsUrl(array $orderedPlaces): string
	{
		// URL-encode each place
		$encodedPlaces = array_map('urlencode', $orderedPlaces);

		// Define origin and destination
		$origin = array_shift($encodedPlaces); // First place
		$destination = array_pop($encodedPlaces); // Last place

		// Join intermediate places as waypoints
		$waypoints = implode('|', $encodedPlaces);

		// Construct the Google Maps Directions URL
		$mapsUrl = "https://www.google.com/maps/dir/?api=1&origin={$origin}&destination={$destination}&waypoints={$waypoints}";

		return $mapsUrl;
	}



    /**
     * Get the transportation mode for the route.
     *
     * @param string $transportation
     * The transportation mode.
     *
     * @return string
     * The transportation mode for the route.
     */
    private function getTransportationMode(string $transportation): string
    {
        return match ($transportation) {
            'CAR' => 'CAR',
            'PUBLIC_TRANSPORT' => 'TRANSIT',
            'WALK' => 'WALK',
            default => 'WALK',
        };
    }
}
