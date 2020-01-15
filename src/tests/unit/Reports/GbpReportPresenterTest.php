<?php

use App\Currencies\CurrencyExchangeService;
use App\Currencies\Entity\Currency;
use App\Reports\GbpReportPresenter;
use App\Transactions\Entity\Transaction;

class GbpReportPresenterTest extends TestCase
{
    public function testDoesNotMapEmptyTransactions()
    {
        $transactions = [];
        $sut = new GbpReportPresenter(\Mockery::mock(CurrencyExchangeService::class));
        $mappedTransactions = $sut->present($transactions);
        $this->assertEmpty($mappedTransactions);
    }

    public function testThrowsExceptionForInvalidList()
    {
        $transactions = [new stdClass(),];
        $sut = new GbpReportPresenter(\Mockery::mock(CurrencyExchangeService::class));
        $this->expectException(InvalidArgumentException::class);
        $sut->present($transactions);
    }

    public function testMapsTransactionsList()
    {
        $transaction = new Transaction(1, \Carbon\Carbon::now(), Currency::USD(), 1002);
        $exchangeServiceMock = \Mockery::mock(CurrencyExchangeService::class);
        $exchangeServiceMock->shouldReceive('exchange')->andReturn('200333');
        $sut = new GbpReportPresenter($exchangeServiceMock);
        $mappedTransactions = $sut->present([$transaction]);
        $this->assertIsArray($mappedTransactions);
        $this->assertCount(1, $mappedTransactions);
        $this->assertEquals(
            [
                'merchant' => 1,
                'date' => '2020-01-15',
                'original_currency' => Currency::USD(),
                'original_value' => 10.02,
                'new_currency' => Currency::GBP(),
                'new_value' => 2003.33,
            ],
            reset($mappedTransactions)
        );
    }
}