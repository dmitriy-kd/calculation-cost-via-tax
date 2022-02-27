<?php

namespace App\Service\CalculationCost;

interface CalculationCostInterface
{
    /**
     * @param integer|float $cost
     * @return float
     */
    public function calculateCost(int|float $cost): float;
}