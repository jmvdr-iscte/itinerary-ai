<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{

	final public function getCollection(): JsonResponse
	{
		return response()->json([]);
	}

	final public function getTransaction(string $uid): JsonResponse
	{
		return response()->json([]);
	}

	final public function createTransaction(Request $request): JsonResponse
	{
		return response()->json([201]);
	}

	final public function handleCallback(Request $request): JsonResponse
	{
		return response()->json([]);
	}
}
