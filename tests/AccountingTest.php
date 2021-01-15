<?php

namespace Tests;

use App\Accounting;
use App\Budget;
use App\BudgetRepo;
use PHPUnit\Framework\TestCase;

class AccountingTest extends TestCase
{
    public $accounting;
    private $budgetRepo;

    protected function setUp()
    {
        $this->budgetRepo = new FakeBudgetRepo();
        $this->accounting = new Accounting($this->budgetRepo);
        parent::setUp();
    }

    public function testNoBudget()
    {
        $totalAmount = $this->accounting->totalAmount(new \DateTime('2021/01/01'), new \DateTime('2021/01/31'));
        $this->assertEquals(0, $totalAmount);
    }

    public function testOneDay()
    {
        $this->budgetRepo->setBudgets([
            new Budget('202101',3100),
        ]);
        $totalAmount = $this->accounting->totalAmount(new \DateTime('2021/01/01'), new \DateTime('2021/01/01'));
        $this->assertEquals(100, $totalAmount);
    }

    public function testMultipleDays()
    {
        $this->budgetRepo->setBudgets([
            new Budget('202102',2800),
        ]);
        $totalAmount = $this->accounting->totalAmount(new \DateTime('2021/02/01'), new \DateTime('2021/02/05'));
        $this->assertEquals(500, $totalAmount);
    }

    public function testMonthly()
    {
        $this->budgetRepo->setBudgets([
            new Budget('202102',2800),
        ]);
        $totalAmount = $this->accounting->totalAmount(new \DateTime('2021/02/01'), new \DateTime('2021/02/28'));
        $this->assertEquals(2800, $totalAmount);
    }

    public function testCrossMonth()
    {
        $this->budgetRepo->setBudgets([
            new Budget('202101',3100),
            new Budget('202102',5600),
        ]);
        $totalAmount = $this->accounting->totalAmount(new \DateTime('2021/01/30'), new \DateTime('2021/02/01'));
        $this->assertEquals(400, $totalAmount);
    }
}


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
