<?php

final class Currency
{
    final public function isSupportedCurrency(string $currency): bool
    {
        $supportedCurrencies = [
            'USD',
            'EUR',
            'GBP',
        ];

        return in_array($currency, $supportedCurrencies);
    }
}
