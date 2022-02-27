<?php

declare(strict_types=1);

namespace App\Service\CalculationCost;

class CalculationCostGerman implements CalculationCostInterface
{
    public string $code = 'DE';
    private float $taxPercent = 1.9;

    /**
     * @param integer|float $cost
     * @return float
     */
    public function calculateCost(int|float $cost): float
    {
        return round($cost + $this->taxPercent, 2);
    }
}