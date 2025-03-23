<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItineraryRequest;
use Illuminate\Http\JsonResponse;
use App\Services\AIService;
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
                continue;
            }
            Log::info('Places ', $details['places']);

            $itinerary[$day]['places'] = $maps_service->getRoutes($body['origin'], $details['places']);
        }

        Mail::to($body['email'])->queue(new Email($itinerary));

		return response()->json(['status' => 'ok']);
	}
}
