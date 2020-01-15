<?php


namespace App\Transactions;


use App\Storage\CsvReader;
use App\Transactions\Entity\TransactionHydrator;

class TransactionRepository
{
    private $database;

    public function __construct(CsvReader $database)
    {
        $this->database = $database;
    }

    public function getTransactionsByMerchantId(int $merchantId)
    {
        $merchantTransactions = new MerchantTransactionsFilterIterator(
            $this->database->readLine(),
            $merchantId
        );

        return array_map(
            function ($transactionData) {
                return TransactionHydrator::fromArray($transactionData);
            },
            iterator_to_array($merchantTransactions)
        );
    }
}