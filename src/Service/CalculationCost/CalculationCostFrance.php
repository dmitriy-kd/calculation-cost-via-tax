<?php

declare(strict_types=1);

namespace App\Service\CalculationCost;

class CalculationCostFrance implements CalculationCostInterface
{
    public string $code = 'FR';
    private float $taxPercent = 2;

    /**
     * @param integer|float $cost
     * @return float
     */
    public function calculateCost(int|float $cost): float
    {
        return round($cost + $this->taxPercent, 2);
    }
}