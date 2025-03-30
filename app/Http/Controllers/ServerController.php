<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItineraryRequest;
use Illuminate\Http\JsonResponse;
use App\Services\AIService;
use App\Services\Client;
use App\Services\Maps;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Services\Email;

class ServerController extends Controller
{

	final public function health(): JsonResponse
	{
		return response()->json(['status' => 'ok']);
	}

	final public function test(ItineraryRequest $request): JsonResponse
	{
		$ai_service = new AIService();
		$maps_service = new Maps();

		$body = $request->validated();

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

        Mail::to($body['email'])->send(new Email($itinerary));

       // $region = Client::getClientRegion($request);

		return response()->json([
            'reult' => $itinerary,
        ]);
	}
}
