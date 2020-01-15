<?php

namespace App\Console\Commands;

use App\Reports\GbpReportPresenter;
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
    private $presenter;

    public function __construct(TransactionRepository $transactions, GbpReportPresenter $presenter)
    {
        parent::__construct();
        $this->transactions = $transactions;
        $this->presenter = $presenter;
    }

    public function handle()
    {
        $merchantId = $this->argument('merchant_id');
        $transactions = $this->transactions->getTransactionsByMerchantId($merchantId);
        $this->table(self::TABLE_HEADERS, $this->presenter->present($transactions));
    }
}