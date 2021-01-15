<?php

namespace App;

class Budget
{
    public $yearMonth = '';
    public $amount = 0;

    public function __construct(string $yearMonth, int $amount)
    {
        $this->yearMonth = $yearMonth;
        $this->amount = $amount;

        return $this;
    }
}
