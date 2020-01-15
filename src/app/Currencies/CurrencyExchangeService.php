<?php

namespace App\Currencies;

use App\Currencies\Entity\Currency;

class CurrencyExchangeService
{
    private $exchangeRates;

    public function __construct(array $exchangeRates)
    {
        $this->exchangeRates = $exchangeRates;
    }

    /**
     * @param int $value
     * @param Currency $from
     * @param Currency $to
     * @return float|int
     */
    public function exchange(int $value, Currency $from, Currency $to) {
        if (!array_key_exists($to->getValue(), $this->exchangeRates)) {
            throw new \InvalidArgumentException(
                'Exchange to ' . $to->getValue() . ' is unsupported.'
            );
        }
        if (!array_key_exists($from->getValue(), $this->exchangeRates[$to->getValue()])) {
            throw new \InvalidArgumentException(
                'Exchange from ' . $to->getValue() . ' is unsupported.'
            );
        }
        return $this->exchangeRates[$to->getValue()][$from->getValue()] * $value;
    }
}