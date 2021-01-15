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
        $budgets = [];
        $dayOfAmount = 0;

        $allBudgets = $this->budgetRepo->getAll();

        if (!$allBudgets) return 0;

        foreach ($allBudgets as $budget) {
            if ($start->format('Ym') == $budget->yearMonth) {
                $budgets[] = $budget;
                continue;
            }
            if ($end->format('Ym') == $budget->yearMonth) {
                $budgets[] = $budget;
                continue;
            }
        }

        if (isset($budgets[0])) {
            $daysOfMonth = cal_days_in_month(CAL_GREGORIAN, $start->format('m'), $start->format('Y'));
            $daysOfPeriod = $end->diff($start)->days + 1;
            $dayOfAmount += $budgets[0]->amount / $daysOfMonth * $daysOfPeriod;
        }


        if (isset($budgets[1])) {
            $daysOfMonth = cal_days_in_month(CAL_GREGORIAN, $end->format('m'), $end->format('Y'));
            $daysOfPeriod = $daysOfMonth - $end->format('d') + 1;
            $dayOfAmount += $budgets[1]->amount / $daysOfMonth * $daysOfPeriod;
        }

        return $dayOfAmount;
    }


}
