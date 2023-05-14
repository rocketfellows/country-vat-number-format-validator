<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit;

use PHPUnit\Framework\TestCase;

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
}
