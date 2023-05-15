<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit;

use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\UnknownInputCountryCodeException;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidatorService;
use rocketfellows\ISOStandard3166Factory\CountryFactory;
use rocketfellows\ISOStandard3166Factory\exceptions\EmptyCountryCodeException;
use rocketfellows\ISOStandard3166Factory\exceptions\UnknownCountryCodeException;

/**
 * @group country-vat-number-format-validator-services
 */
class VatNumberFormatValidatorServiceTest extends TestCase
{
    private const COUNTRY_CODE_TEST_VALUE = 'foo';
    private const VAT_NUMBER_TEST_VALUE = '123123213';

    /**
     * @var VatNumberFormatValidatorService
     */
    private $vatNumberFormatValidatorService;

    /**
     * @var CountryVatNumberFormatValidatorsConfigs|MockObject
     */
    private $countryVatNumberFormatValidatorsConfigs;

    /**
     * @var CountryFactory|MockObject
     */
    private $countryFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->countryVatNumberFormatValidatorsConfigs = $this->createMock(
            CountryVatNumberFormatValidatorsConfigs::class
        );
        $this->countryFactory = $this->createMock(
            CountryFactory::class
        );

        $this->vatNumberFormatValidatorService = new VatNumberFormatValidatorService(
            $this->countryVatNumberFormatValidatorsConfigs,
            $this->countryFactory
        );
    }

    public function testValidatorThrowsExceptionCauseInputCountryCodeEmpty(): void
    {
        /** @var Exception $factoryEmptyCountryCodeException */
        $factoryEmptyCountryCodeException = $this->createMock(EmptyCountryCodeException::class);

        $this->expectException(CountryCodeEmptyException::class);
        $this->expectExceptionObject(
            new CountryCodeEmptyException(
                '',
                $factoryEmptyCountryCodeException->getMessage(),
                $factoryEmptyCountryCodeException->getCode(),
                $factoryEmptyCountryCodeException
            )
        );

        $this->countryFactory
            ->expects($this->once())
            ->method('createByCode')
            ->with('')
            ->willThrowException($factoryEmptyCountryCodeException);

        $this->vatNumberFormatValidatorService->validateCountryVatNumber(
            '',
            self::VAT_NUMBER_TEST_VALUE
        );
    }

    public function testValidatorThrowsExceptionCauseInputCountryCodeUnknown(): void
    {
        /** @var Exception $factoryUnknownCountryCodeException */
        $factoryUnknownCountryCodeException = $this->createMock(UnknownCountryCodeException::class);

        $this->expectException(UnknownInputCountryCodeException::class);
        $this->expectExceptionObject(
            new UnknownInputCountryCodeException(
                self::COUNTRY_CODE_TEST_VALUE,
                $factoryUnknownCountryCodeException->getMessage(),
                $factoryUnknownCountryCodeException->getCode(),
                $factoryUnknownCountryCodeException
            )
        );

        $this->countryFactory
            ->expects($this->once())
            ->method('createByCode')
            ->with(self::COUNTRY_CODE_TEST_VALUE)
            ->willThrowException($factoryUnknownCountryCodeException);

        $this->vatNumberFormatValidatorService->validateCountryVatNumber(
            self::COUNTRY_CODE_TEST_VALUE,
            self::VAT_NUMBER_TEST_VALUE
        );
    }
}
