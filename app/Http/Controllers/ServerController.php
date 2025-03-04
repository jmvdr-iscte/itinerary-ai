<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class ServerController extends Controller
{

	final public function health(): JsonResponse
	{
		return response()->json(['status' => 'ok']);
	}
}
