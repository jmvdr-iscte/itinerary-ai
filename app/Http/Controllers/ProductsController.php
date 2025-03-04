<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
	final public function createProduct(Request $request): JsonResponse
	{
		return response()->json([201]);
	}

	final public function getCollection(): JsonResponse
	{
		return response()->json([]);
	}

	final public function updateProduct(string $uid, Request $request): JsonResponse
	{
		return response()->json([]);
	}
}
