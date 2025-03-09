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
     * @param array $places
     * @return string
     * @throws \Exception
     */
    public function getRoutes(string $origin, array $places): string
    {
        // Geocode origin and places
        $originCoords = $this->geocodeAddress($origin);
        if (!$originCoords) {
            throw new \Exception('Origin address could not be geocoded.');
        }

        $placesCoords = [];
        foreach ($places as $place) {
            $coords = $this->geocodeAddress($place);
            if ($coords) {
                $placesCoords[] = $coords;
            } else {
                throw new \Exception("Address '{$place}' could not be geocoded.");
            }
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
            'intermediates' => array_map(function ($place) {
                return [
                    'location' => [
                        'latLng' => [
                            'latitude' => $place['latitude'],
                            'longitude' => $place['longitude'],
                        ],
                    ],
                ];
            }, array_slice($placesCoords, 0, -1)),
            'optimizeWaypointOrder' => true,
        ];

        // Define the fields to be returned in the response
        $fieldMask = 'routes.optimizedIntermediateWaypointIndex';

        // Send the request to the Routes API
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Goog-Api-Key' => $this->api_key,
            'X-Goog-FieldMask' => $fieldMask,
        ])->post('https://routes.googleapis.com/directions/v2:computeRoutes', $payload);

        if ($response->successful()) {
            $data = $response->json();

            if (!isset($data['routes'][0]['optimizedIntermediateWaypointIndex'])) {
                throw new \Exception('Google API did not return optimized waypoint order.');
            }

            $optimizedOrder = $data['routes'][0]['optimizedIntermediateWaypointIndex'];

            // Reorder places based on optimized order
            $orderedPlaces = [$origin]; // Start with origin
            foreach ($optimizedOrder as $index) {
                //TODO: Fix this
                // if ($index < 0) {
                //     continue;
                // }

                $orderedPlaces[] = $places[$index]; // Add places in optimized order
            }
            $orderedPlaces[] = end($places); // End with final destination

            // Generate Google Maps URL
            $mapsUrl = $this->generateMapsUrl($orderedPlaces);

            return $mapsUrl;
        } else {
            throw new \Exception('Error fetching routes: ' . $response->body());
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
}
