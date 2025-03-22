<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
	final public function createProduct(CreateProduct $request): JsonResponse
	{
		$body = $request->validated();

        Product::create([
            'uid' => Str::uuid(),
            'name' => $body['name'],
            'value' => $body['value'],
            'currency' => $body['currency'],
            'status' => 'ACTIVE'
        ]);


		return response()->json([], 201);
    }

	final public function updateProduct(string $uid, Request $request): JsonResponse
	{
		return response()->json([]);
	}
}
