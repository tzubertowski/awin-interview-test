<?php

use App\Currencies\CurrencyExchangeService;
use App\Currencies\Entity\Currency;

class CurrencyExchangeServiceTest extends TestCase
{
    public function testThrowsExceptionForUnsupportedTargetCurrency() {
        $config = [
            '£' => [
                '$' => 1.30,
                '€' => 1.17,
                '£' => 1,
            ],
        ];
        $sut = new CurrencyExchangeService($config);
        $this->expectException(InvalidArgumentException::class);
        $sut->exchange(100, Currency::USD(), Currency::EUR());
    }

    public function testThrowsExceptionForUnsupportedSourceCurrency()
    {
        $config = [
            '£' => [
                '€' => 1.17,
                '£' => 1,
            ],
        ];
        $sut = new CurrencyExchangeService($config);
        $this->expectException(InvalidArgumentException::class);
        $sut->exchange(100, Currency::USD(), Currency::GBP());
    }

    public function testExchangesWithoutRounding()
    {
        $config = [
            '£' => [
                '€' => 117,
            ],
        ];
        $sut = new CurrencyExchangeService($config);
        $exchangedValue = $sut->exchange(100, Currency::EUR(), Currency::GBP());
        $this->assertEquals($exchangedValue, 117);
    }

    /**
     * PHP gets iffy with multiplication of floats, thus using ints
     *
     * eg. 100.00 * 10206.37 != 10000 * 1020637
     */
    public function testMultipliesFloatsWithoutRounding()
    {
        $config = [
            '£' => [
                '€' => 10000,
            ],
        ];
        $value = 1020637;
        $sut = new CurrencyExchangeService($config);
        $exchangedValue = $sut->exchange($value, Currency::EUR(), Currency::GBP());
        $this->assertEquals(102063700, $exchangedValue);
    }
}