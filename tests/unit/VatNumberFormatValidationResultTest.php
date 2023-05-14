<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit;

use PHPUnit\Framework\TestCase;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidationResult;

class VatNumberFormatValidationResultTest extends TestCase
{
    /**
     * @dataProvider getVatNumberFormatValidationResultWithRequiredParamsProvidedData
     */
    public function testInitVatNumberFormatValidationResultWithRequiredParams(
        bool $isValid,
        array $passedValidatorsClasses
    ): void {
        $vatNumberFormatValidationResult = new VatNumberFormatValidationResult(
            $isValid,
            $passedValidatorsClasses
        );

        $this->assertEquals($isValid, $vatNumberFormatValidationResult->isValid());
        $this->assertEquals($passedValidatorsClasses, $vatNumberFormatValidationResult->getPassedValidatorsClasses());
    }

    public function getVatNumberFormatValidationResultWithRequiredParamsProvidedData(): array
    {
        return [
            'is valid false, passed validators classes empty' => [
                'isValid' => false,
                'passedValidatorsClasses' => [],
            ],
            'is valid true, passed validators classes empty' => [
                'isValid' => true,
                'passedValidatorsClasses' => [],
            ],
            'is valid false, passed validators classes not empty' => [
                'isValid' => false,
                'passedValidatorsClasses' => ['foo', 'bar',],
            ],
            'is valid true, passed validators classes not empty' => [
                'isValid' => true,
                'passedValidatorsClasses' => ['foo', 'bar',],
            ],
        ];
    }

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
            'is valid true, passed validators classes empty, successfully validator class null' => [
                'isValid' => true,
                'passedValidatorsClasses' => [],
                'successfullyValidatorClass' => null,
            ],
            'is valid false, passed validators classes not empty, successfully validator class null' => [
                'isValid' => false,
                'passedValidatorsClasses' => ['foo', 'bar',],
                'successfullyValidatorClass' => null,
            ],
            'is valid true, passed validators classes not empty, successfully validator class null' => [
                'isValid' => true,
                'passedValidatorsClasses' => ['foo', 'bar',],
                'successfullyValidatorClass' => null,
            ],
            'is valid false, passed validators classes empty, successfully validator class not null' => [
                'isValid' => false,
                'passedValidatorsClasses' => [],
                'successfullyValidatorClass' => 'foo',
            ],
            'is valid true, passed validators classes empty, successfully validator class not null' => [
                'isValid' => true,
                'passedValidatorsClasses' => [],
                'successfullyValidatorClass' => 'foo',
            ],
            'is valid true, passed validators classes not empty, successfully validator class not null' => [
                'isValid' => true,
                'passedValidatorsClasses' => ['bar', 'fooBar',],
                'successfullyValidatorClass' => 'foo',
            ],
        ];
    }
}
