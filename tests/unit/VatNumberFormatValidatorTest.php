<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidator;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidatorService;

/**
 * @group country-vat-number-format-validator-services
 */
class VatNumberFormatValidatorTest extends TestCase
{
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
    }
}
