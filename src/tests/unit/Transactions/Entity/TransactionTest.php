<?php

use App\Transactions\Entity\Currency;
use App\Transactions\Entity\Transaction;
use Carbon\Carbon;

/**
 * Tests Transaction behaviour
 *
 * Redundant tests like strict type arguments are skipped
 */
class TransactionTest extends TestCase
{
    /**
     * @param int $id
     * @param DateTime $date
     * @param Currency $currency
     * @param float $value
     *
     * @dataProvider provideValidTransactionData
     */
    public function testCanInstantiateWithRequiredFields(
        int $id,
        DateTime $date,
        Currency $currency,
        float $value
    ) {
        $transaction = new Transaction($id, $date, $currency, $value);
        $this->assertInstanceOf(Transaction::class, $transaction);
    }

    public function provideValidTransactionData()
    {
        return [
            [1, Carbon::parse('01/05/2010'), Currency::GBP(), 50.01],
            [2, Carbon::parse('01/05/2010'), Currency::USD(), 66.10,],
            [2, Carbon::parse('02/05/2010'), Currency::EUR(), 12.00,],
        ];
    }
}