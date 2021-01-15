<?php

namespace Tests;

use App\BudgetRepo;

class FakeBudgetRepo extends BudgetRepo
{
    /**
     * @var array
     */
    private $budgets;

    public function getAll()
    {
        return $this->budgets;
    }

    public function setBudgets(array $array)
    {
        $this->budgets = $array;
    }
}
