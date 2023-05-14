<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit;

use PHPUnit\Framework\TestCase;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidatorService;

/**
 * @group country-vat-number-format-validator-services
 */
class VatNumberFormatValidatorServiceTest extends TestCase
{
    /**
     * @var VatNumberFormatValidatorService
     */
    private $vatNumberFormatValidatorService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->vatNumberFormatValidatorService = new VatNumberFormatValidatorService();
    }

    public function testValidatorThrowsExceptionCauseInputCountryCodeEmpty(): void
    {
        $this->expectException(CountryCodeEmptyException::class);
        $this->expectExceptionObject(new CountryCodeEmptyException(''));

        $this->vatNumberFormatValidatorService->validateCountryVatNumber('', '');
    }
}
