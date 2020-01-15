<?php

namespace App\Transactions\Entity;

use MyCLabs\Enum\Enum;
use App\Exceptions\CurrencyUnsupportedException;

class Currency extends Enum
{
    private const GBP = '£';
    private const USD = '$';
    private const EUR = '€';

    public static function fromCurrencyCode(string $currency): self
    {
        if (!in_array($currency, self::toArray())) {
            throw new CurrencyUnsupportedException($currency . ' is not supported');
        }
        return new self($currency);
    }
}