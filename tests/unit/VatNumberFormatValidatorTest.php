<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidationResult;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidator;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidatorService;

/**
 * @group country-vat-number-format-validator-services
 */
class VatNumberFormatValidatorTest extends TestCase
{
    private const COUNTRY_CODE_TEST_VALUE = 'foo';
    private const VAT_NUMBER_TEST_VALUE = '123';

    /**
     * @var VatNumberFormatValidator
     */
    private $vatNumberFormatValidator;

    /**
     * @var VatNumberFormatValidatorService|MockObject
     */
    private $vatNumberFormatValidatorService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->vatNumberFormatValidatorService = $this->createMock(VatNumberFormatValidatorService::class);

        $this->vatNumberFormatValidator = new VatNumberFormatValidator(
            $this->vatNumberFormatValidatorService
        );
    }

    public function testCountryVatNumberIsValid(): void
    {
        $validationResult = $this->getVatNumberFormatValidationResultMock();
        $validationResult
            ->expects($this->once())
            ->method('isValid')
            ->willReturn(true);

        $this->vatNumberFormatValidatorService
            ->expects($this->once())
            ->method('validateCountryVatNumber')
            ->willReturn($validationResult);

        $this->assertTrue(
            $this->vatNumberFormatValidator->isValid(
                self::COUNTRY_CODE_TEST_VALUE,
                self::VAT_NUMBER_TEST_VALUE
            )
        );
    }

    private function getVatNumberFormatValidationResultMock(): MockObject
    {
        /** @var VatNumberFormatValidationResult|MockObject $mock */
        $mock = $this->createMock(VatNumberFormatValidationResult::class);

        return $mock;
    }
}
