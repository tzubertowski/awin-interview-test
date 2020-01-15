<?php

use App\Exceptions\Transactions\CurrencyUnsupportedException;
use App\Currencies\Entity\Currency;

class CurrencyTest extends TestCase
{
    /**
     * @dataProvider provideValidCurrencyCodes
     * @param string $currencyCode
     */
    public function testCanInstantiateWithValidCurrency(string $currencyCode)
    {
        $currency = Currency::fromCurrencyCode($currencyCode);
        $this->assertInstanceOf(Currency::class, $currency);
    }

    public function provideValidCurrencyCodes()
    {
        return [
            ['$'],
            ['£'],
            ['€'],
        ];
    }

    /**
     * @dataProvider provideInvalidCurrencyCodes
     * @param string $currencyCode
     */
    public function testCannotInstantiateWithInvalidCurrency(string $currencyCode)
    {
        $this->expectException(CurrencyUnsupportedException::class);
        Currency::fromCurrencyCode($currencyCode);
    }

    public function provideInvalidCurrencyCodes()
    {
        return [
            ['¢'],
            ['₪'],
            ['¥'],
        ];
    }

}