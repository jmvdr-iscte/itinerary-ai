<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProduct;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Utils\Currency;
use Illuminate\Support\Str;
use App\Services\Client;

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

    final public function getProduct(Request $request): JsonResponse
    {
        $region = Client::getClientRegion($request);
        $currency = Currency::isSupportedCurrency($region['currency']) ? $region['currency'] : 'USD';

        $product = Product::where('currency', $currency)
            ->where('status', 'ACTIVE')
            ->first();

        if ($product === null) {
            return response()->json(['result' => 'Product not found'], 404);
        }

        //return
        return response()->json($product->makeHidden(['id']));
    }



	final public function updateProduct(string $uid, UpdateProductRequest $request): JsonResponse
	{
        $body = $request->validated();
        $product = Product::where('uid', $uid)
            ->first();

        $product->update($body);

		return response()->json([], 204);
	}
}
