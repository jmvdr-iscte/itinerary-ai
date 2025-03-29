<?php

namespace App\Utils;

final class Price
{
    private const THRESHOLD = 0.3;

    final public static function isValidPrice(string $transaction_price, string $product_price): bool
    {
        $difference = abs($transaction_price - $product_price);

        return ($difference / max($transaction_price, $product_price)) <= self::THRESHOLD;
    }
}
