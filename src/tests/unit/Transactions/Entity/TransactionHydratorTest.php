<?php

use App\Exceptions\Transactions\InvalidTransactionDateException;
use App\Exceptions\Transactions\InvalidTransactionValueException;
use App\Currencies\Entity\Currency;
use App\Transactions\Entity\Transaction;
use App\Transactions\Entity\TransactionHydrator;
use Carbon\Carbon;

class TransactionHydratorTest extends TestCase
{
    /**
     * @param array $transactionFields
     * @param Currency $expectedCurrency
     *
     * @dataProvider provideValidTransactionFields
     */
    public function testHydratesWithValidFields(array $transactionFields, Currency $expectedCurrency, float $expectedValue)
    {
        $transaction = TransactionHydrator::fromArray($transactionFields);
        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals((int) $transactionFields[0], $transaction->merchant);
        $this->assertEquals(Carbon::parse($transactionFields[1]), $transaction->date);
        $this->assertEquals($expectedCurrency, $transaction->currency);
        $this->assertEquals($expectedValue, $transaction->value);
    }

    public function provideValidTransactionFields()
    {
        return [
            [[1, "01/05/2010", "£50.00",], Currency::GBP(), 5000],
            [['2', "01/05/2010", "$66.10",], Currency::USD(), 6610],
            [['2', "02/05/2010", "€12.00",], Currency::EUR(), 1200],
        ];
    }

    /**
     * @param array $transactionFields
     * @param $expectedException
     *
     * @dataProvider provideInvalidTransactionFields
     */
    public function testDoesNotHydrateWithInvalidFields(array $transactionFields, $expectedException)
    {
        $sut = new TransactionHydrator();
        $this->expectException($expectedException);
        TransactionHydrator::fromArray($transactionFields);
    }

    public function provideInvalidTransactionFields()
    {
        return [
            [[1, "01/02010", "£50.00",], InvalidTransactionDateException::class],
            [[1, "01/01/2010", "£ha",], InvalidTransactionValueException::class],
            [[1, "01/01/2010", "£ha", 'additional'], InvalidArgumentException::class],
        ];
    }

}