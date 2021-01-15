<?php

namespace App;

use DateTime;

class Accounting
{
    /**
     * @var BudgetRepo
     */
    private $budgetRepo;

    /**
     * Accounting constructor.
     * @param BudgetRepo $budgetRepo
     */
    public function __construct(\App\BudgetRepo $budgetRepo)
    {
        $this->budgetRepo = $budgetRepo;
    }

    public function totalAmount(DateTime $start, DateTime $end)
    {
        $budgets = $this->budgetRepo->getAll();

        $b = $budgets[0];
        $d = $end->diff($start)->days + 1;
        $dayOfAmount = $b->amount / 31;

        return $dayOfAmount * $d;
    }
}
