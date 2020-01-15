<?php

namespace App\Console\Commands;

use App\Currencies\Entity\CurrencyExchangeService;
use App\Transactions\TransactionRepository;
use Illuminate\Console\Command;

class MerchantReportCommand extends Command
{
    const TABLE_HEADERS = [
        'Merchant ID',
        'Transaction Date',
        'Original Transaction Currency',
        'Original Transaction Value',
        'Report Transaction Currency',
        'Transaction Value'
    ];
    protected $signature = 'merchant:transaction_report {merchant_id}';
    protected $description = 'Generates report of transactions for a given merchant';

    private $transactions;
    private $exchangeService;

    public function __construct(TransactionRepository $transactions, CurrencyExchangeService $exchangeService)
    {
        parent::__construct();
        $this->transactions = $transactions;
        $this->exchangeService = $exchangeService;
    }

    public function handle()
    {
        $merchantId = $this->argument('merchant_id');
        $transactions = $this->transactions->getTransactionsByMerchantId($merchantId);

        $this->table(self::TABLE_HEADERS, $transactions);
    }
}