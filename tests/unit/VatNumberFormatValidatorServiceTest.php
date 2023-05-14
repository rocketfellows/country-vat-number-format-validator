<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit;

use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\UnknownInputCountryCodeException;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidatorService;
use rocketfellows\ISOStandard3166Factory\CountryFactory;

/**
 * @group country-vat-number-format-validator-services
 */
class VatNumberFormatValidatorServiceTest extends TestCase
{
    /**
     * @var VatNumberFormatValidatorService
     */
    private $vatNumberFormatValidatorService;

    /**
     * @var CountryFactory|MockObject
     */
    private $countryFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->countryFactory = $this->createMock(CountryFactory::class);

        $this->vatNumberFormatValidatorService = new VatNumberFormatValidatorService();
    }

    public function testValidatorThrowsExceptionCauseInputCountryCodeEmpty(): void
    {
        $this->expectException(CountryCodeEmptyException::class);
        $this->expectExceptionObject(new CountryCodeEmptyException(''));

        $this->vatNumberFormatValidatorService->validateCountryVatNumber('', '');
    }

    public function testValidatorThrowsExceptionCauseInputCountryCodeUnknown(): void
    {
        $unknownInputCountryCode = 'foo';
        /** @var Exception $factoryUnknownCountryCodeException */
        $factoryUnknownCountryCodeException = $this->createMock(UnknownCountryCodeException::class);

        $this->expectException(UnknownInputCountryCodeException::class);
        $this->expectExceptionObject(
            new UnknownInputCountryCodeException(
                $unknownInputCountryCode,
                $factoryUnknownCountryCodeException->getMessage(),
                $factoryUnknownCountryCodeException->getCode(),
                $factoryUnknownCountryCodeException
            )
        );

        $this->countryFactory
            ->expects($this->once())
            ->method('createByCode')
            ->with($unknownInputCountryCode)
            ->willThrowException($factoryUnknownCountryCodeException);

        $this->vatNumberFormatValidatorService->validateCountryVatNumber($unknownInputCountryCode, '');
    }
}
