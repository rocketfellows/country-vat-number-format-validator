<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit;

use PHPUnit\Framework\TestCase;

class VatNumberFormatValidationResultTest extends TestCase
{
    /**
     * @dataProvider getVatNumberFormatValidationResultProvidedData
     */
    public function testInitVatNumberFormatValidationResultFromInputParameters(
        bool $isValid,
        array $passedValidatorsClasses,
        ?string $successfullyValidatorClass
    ): void {
        $vatNumberFormatValidationResult = new VatNumberFormatValidationResult(
            $isValid,
            $passedValidatorsClasses,
            $successfullyValidatorClass
        );

        $this->assertEquals($isValid, $vatNumberFormatValidationResult->isValid());
        $this->assertEquals($passedValidatorsClasses, $vatNumberFormatValidationResult->getPassedValidatorsClasses());
        $this->assertEquals($successfullyValidatorClass, $vatNumberFormatValidationResult->getSuccessfullyValidatorClass());
    }

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
