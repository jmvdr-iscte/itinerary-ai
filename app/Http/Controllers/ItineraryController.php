<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ItineraryRequest;
use App\Services\AIService;
use App\Services\Maps;
use Illuminate\Support\Facades\Log;
use App\Models\Itinerary;

class ItineraryController extends Controller
{

    final public function createItinerary(ItineraryRequest $request): JsonResponse
    {
		//init
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
            $body['budget']
		);

        foreach ($itinerary as $day => $details) {
            if (!isset($details['places'])) {
                throw new \Exception('Invalid places.');
            }

            $itinerary[$day]['places'] = $maps_service->getRoutes($body['origin'], $details['places']);
        }

       $itinerary = Itinerary::create([
            'uid' => uniqid(),
            'status' => 'CREATED',
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

        //TODO:create transaction


        return response()->json([
            'uid' => $itinerary->uid,
        ]);
    }
}
