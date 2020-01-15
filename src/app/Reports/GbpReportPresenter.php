<?php

namespace App\Reports;


use App\Currencies\Entity\Currency;
use App\Currencies\CurrencyExchangeService;
use App\Transactions\Entity\Transaction;
use InvalidArgumentException;

class GbpReportPresenter
{
    private $exchangeService;

    public function __construct(CurrencyExchangeService $exchangeService)
    {
        $this->exchangeService = $exchangeService;
    }

    /**
     * Presents Transaction value for the report
     *
     * @param array $transactions
     * @return array
     */
    public function present(array $transactions)
    {
        /** @var Transaction $transaction */
        $exchangedTransactions = [];
        foreach ($transactions as $transaction) {
            if (!$transaction instanceof Transaction) {
                throw new InvalidArgumentException('Can only present Transction::class objects list');
            }
            $exchangedValue = $this->exchangeService->exchange(
                $transaction->value,
                $transaction->currency,
                Currency::GBP()
            );
            $exchangedTransactions[] = [
                'merchant' => $transaction->merchant,
                'date' => $transaction->date->format('Y-m-d'),
                'original_currency' => $transaction->currency,
                'original_value' => (float) round($transaction->value / 100, 2),
                'new_currency' => Currency::GBP()->getValue(),
                'new_value' => (float) round($exchangedValue / 100, 2),
            ];
        }

        return $exchangedTransactions;
    }
}