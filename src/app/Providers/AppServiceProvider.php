<?php

namespace App\Providers;

use App\Console\Commands\MerchantReportCommand;
use App\Currencies\CurrencyExchangeService;
use App\Reports\GbpReportPresenter;
use App\Storage\CsvReader;
use App\Transactions\Entity\TransactionHydrator;
use App\Transactions\TransactionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CurrencyExchangeService::class, function ($app) {
           return new CurrencyExchangeService(config('currencyExchangeRates'));
        });
        $this->app->bind(CsvReader::class, function ($app) {
            return new CsvReader(fopen(
                storage_path('app/data/data.csv'),
                'c+'
            ));
        });
        $this->app->bind(TransactionRepository::class, function ($app) {
            return new TransactionRepository(
                $app->make(CsvReader::class),
                new TransactionHydrator()
            );
        });
        $this->app->bind(GbpReportPresenter::class, function ($app) {
            return new GbpReportPresenter(
                $app->make(CurrencyExchangeService::class)
            );
        });
        $this->app->bind(MerchantReportCommand::class, function ($app) {
           return new MerchantReportCommand(
               $app->make(TransactionRepository::class),
               $app->make(GbpReportPresenter::class)
           );
        });
    }
}
