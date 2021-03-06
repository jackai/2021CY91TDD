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
        if ($end < $start) return 0;

        $budgets = [];
        $allBudgets = $this->budgetRepo->getAll();

        if (!$allBudgets) return 0;

        $allAmount = 0;

        foreach ($allBudgets as $budget) {
            if (
                $start->format('Ym') <= $budget->yearMonth &&
                $end->format('Ym') >= $budget->yearMonth
            ) {
                $budgets[$budget->yearMonth] = $budget;
                $allAmount += $budget->amount;
            }
        }

        if (isset($budgets[$start->format('Ym')])) {
            $daysOfMonth = $this->getDaysOfMonth($start);
            $daysOfPeriod = $start->format('d') - 1;
            $allAmount -= $budgets[$start->format('Ym')]->amount / $daysOfMonth * $daysOfPeriod;
        }

        if (isset($budgets[$end->format('Ym')])) {
            $daysOfMonth = $this->getDaysOfMonth($end);
            $daysOfPeriod = $daysOfMonth - $end->format('d');
            $allAmount -= $budgets[$end->format('Ym')]->amount / $daysOfMonth * $daysOfPeriod;
        }

        return $allAmount;
    }

    public function getDaysOfMonth(DateTime $dateTime): int
    {
        return cal_days_in_month(CAL_GREGORIAN, $dateTime->format('m'), $dateTime->format('Y'));
    }
}
