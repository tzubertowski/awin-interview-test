<?php
/**
 * Created by PhpStorm.
 * User: prosty
 * Date: 15/01/2020
 * Time: 13:13
 */

namespace App\Transactions;


use App\Transactions\Entity\TransactionHydrator;
use Iterator;

class MerchantTransactionsFilterIterator extends \FilterIterator
{
    private $merchantId;

    public function __construct(Iterator $iterator, int $merchantId)
    {
        parent::__construct($iterator);
        $this->merchantId = $merchantId;
    }

    public function accept()
    {
        $transactionData = $this->current();
        $transaction = TransactionHydrator::fromArray($transactionData);
        return $transaction->merchant === $this->merchantId;
    }
}