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
                '€' => 1.17,
            ],
        ];
        $sut = new CurrencyExchangeService($config);
        $exchangedValue = $sut->exchange(100, Currency::EUR(), Currency::GBP());
        $this->assertEquals($exchangedValue, 100 * 1.17);
    }
}