<?php

class BudgetRepo
{
    public function getAll()
    {
        return [
            new Budget(),
            new Budget(),
            new Budget(),
            new Budget(),
            new Budget(),
        ];
    }
}
