<?php

namespace App\Utils;

final class Currency
{
    final public static function isSupportedCurrency(string $currency): bool
    {
        $supportedCurrencies = [
            'USD',
            'EUR',
            'GBP',
        ];

        return in_array($currency, $supportedCurrencies);
    }
}
