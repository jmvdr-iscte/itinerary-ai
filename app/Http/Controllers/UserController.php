<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\SaveEmailRequest;
use App\Http\Requests\SupportUserRequest;
use App\Services\Client;

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


    final public function supportUser(SupportUserRequest $request): JsonResponse
    {
        $body = $request->validated();
        Client::saveSupport($body['email'], $body['content'], $body['name'], $body['title'] ?? null);

        //return
        return response()->json([], 201);
    }
}
