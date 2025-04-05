<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\ItineraryRequest;
use App\Services\AIService;
use App\Services\Maps;
use App\Models\Itinerary;
use App\Services\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ItineraryController extends Controller
{
	final public function createItinerary(ItineraryRequest $request): JsonResponse
	{
		//init
		$ai_service = new AIService();
		$maps_service = new Maps();

		$body = $request->validated();

		//save email
		Client::saveEmail($body['email']);

		$itinerary = $ai_service->getItinerary(
			$body['from'],
			$body['to'],
			$body['destination'],
			$body['categories'],
			$body['transportation'],
			$body['number_of_people'],
			$body['budget'],
			$body['activity_pace'] ?? null,
			$body['must_see_attractions'] ?? null
		);

		foreach ($itinerary as $day => $details) {
			if (!isset($details['places']) || !is_array($details['places'])) {
				Log::error('Invalid places.', $day, $details);
				continue;
			}

			$addresses = array_map(function($place) {
				return $place['address'];
			}, $details['places']);

			$itinerary[$day]['places'] = $maps_service->getRoutes($body['origin'], $addresses, $itinerary[$day]['transportation']);
		}

	   $itinerary = Itinerary::create([
			'uid' => Str::uuid(),
			'status' => 'PENDING',
			'email' => $body['email'],
			'itinerary' => $itinerary,
			'destination' => $body['destination'],
			'categories' => $body['categories'],
			'transportation' => $body['transportation'],
			'number_of_people' => $body['number_of_people'],
			'origin' => $body['origin'],
			'from' => $body['from'],
			'to' => $body['to'],
			'budget' => $body['budget'],
			'currency' => $body['currency'],
		]);

		return response()->json([
			'uid' => $itinerary->uid,
		], 201);
	}
}
