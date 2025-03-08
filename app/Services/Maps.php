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



	//Add locales
	final public function getRoutes(string $origin,
		string $destination,
		array $waypoints = [],
		string $transportation = 'DRIVE'
	): ?string
	{
		$headers = [
			'Content-Type' => 'application/json',
			'X-Goog-Api-Key' => $this->api_key,
			'X-Goog-FieldMask' => 'routes.routeLabels,routes.legs'
		];

		$body = [
			'origin' => ['address' => $origin],
			'destination' => ['address' => $destination],
			'travelMode' => $transportation,
			'routingPreference' => 'TRAFFIC_AWARE_OPTIMAL'
		];

		if (!empty($waypoints)) {
			$body['intermediates'] = array_map(fn($w) => ['address' => $w], $waypoints);
		}

		try {
			$response = Http::withHeaders($headers)->post($this->base_url, $body);

			if ($response->successful()) {
				$data = $response->json();
				if (isset($data['routes'][0]['legs'])) {
					return $this->generateMapsUrl($origin, $destination, $waypoints);
				}
			} else {
				Log::error("Google Maps API Error: " . $response->body());
			}
		} catch (\Exception $e) {
			Log::error("Google Maps API Exception: " . $e->getMessage());
		}

		return '';
	}



	private function generateMapsUrl(string $origin, string $destination, array $waypoints = []): string
	{
		$waypoints_string = !empty($waypoints) ? implode('/', array_map('urlencode', $waypoints)) . '/' : '';

		return "https://www.google.com/maps/dir/" .
			urlencode($origin) . '/' .
			$waypoints_string .
			urlencode($destination);
	}
}
