<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ItineraryController extends Controller
{

    final public function createItinerary(Request $request): JsonResponse
    {

        return response()->json([201]);
    }
}
