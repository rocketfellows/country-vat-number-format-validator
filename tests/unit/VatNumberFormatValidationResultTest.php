<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit;

use PHPUnit\Framework\TestCase;

class VatNumberFormatValidationResultTest extends TestCase
{
    public function getVatNumberFormatValidationResultProvidedData(): array
    {
        return [
            'is valid false, passed validators classes empty, successfully validator class null' => [
                'isValid' => false,
                'passedValidatorsClasses' => [],
                'successfullyValidatorClass' => null,
            ],
        ];
    }
}
