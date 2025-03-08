<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItineraryRequest;
use Illuminate\Http\JsonResponse;
use App\Services\AIService;

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

		$body = $request->validated();

		$itinerary = $ai_service->getItinerary(
			$body['origin'],
			$body['from'],
			$body['to'],
			$body['destination'],
			$body['categories'],
			$body['transportation'],
			$body['number_of_people'],
		);
		return response()->json([$body]);
	}
}
