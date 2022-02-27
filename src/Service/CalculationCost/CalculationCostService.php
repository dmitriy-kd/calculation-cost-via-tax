<?php

declare(strict_types=1);

namespace App\Service\CalculationCost;

use App\Form\CostForm;
use Exception;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class CalculationCostService
{
    /**
     * @param string $taxNumber
     * @return CalculationCostInterface
     */
    private function createCalculationCostEntity(string $taxNumber): CalculationCostInterface
    {
        if (preg_match('/(DE\d{9})/', $taxNumber) === 1) {
            return new CalculationCostGerman();
        } elseif (preg_match('/(FR[A-Z]{2}\d{9})/', $taxNumber) === 1) {
            return new CalculationCostFrance();
        } else {
            throw new Exception('Not valid tax number');
        }

    }

    /**
     * @param CostForm $costForm
     * @return float
     */
    public function calculate(CostForm $costForm): float
    {
        $calculationCostEntity = $this->createCalculationCostEntity($costForm->taxNumber);
        $cache = new FilesystemAdapter();
        $cacheItem = $cache->getItem("{$calculationCostEntity->code}.{$costForm->cost}");

        if (!$cacheItem->isHit()) {
            $cost = $calculationCostEntity->calculateCost($costForm->cost);
            $cacheItem->set($cost);
            $cache->save($cacheItem);
        } else {
            $cost = $cacheItem->get();
        }

        return $cost;
    }
}