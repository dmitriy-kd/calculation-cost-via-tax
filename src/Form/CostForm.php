<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class CostForm
{
    public int $cost;
    public string $taxNumber;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('taxNumber', new Assert\Regex([
            'pattern' => '/(DE\d{9})|(FR[A-Z]{2}\d{9})/',
            'message' => 'Tax number does not match the format'
        ]));
    }
}