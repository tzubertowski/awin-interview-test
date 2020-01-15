<?php

namespace App\Transactions\Entity;

use App\Currencies\Entity\Currency;
use DateTime;

class Transaction
{
    public $merchant;
    public $date;
    public $currency;
    public $value;

    public function __construct(int $merchant, DateTime $date, Currency $currency, float $value)
    {
        $this->merchant = $merchant;
        $this->date = $date;
        $this->currency = $currency;
        $this->value = $value;
    }
}