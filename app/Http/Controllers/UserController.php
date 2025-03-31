<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\SaveEmailRequest;
use App\Services\AIService;
use App\Services\Maps;
use App\Models\Itinerary;
use App\Services\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{

    /**
     * Save user email
     *
     * @param \App\Http\Requests\SaveEmailRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * The response.
     */
    final public function saveEmail(SaveEmailRequest $request): JsonResponse
    {
        Client::saveEmail($request->validated('email'));

        //return
        return response()->json([], 201);
    }
}
