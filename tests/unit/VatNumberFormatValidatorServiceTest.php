<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit;

use arslanimamutdinov\ISOStandard3166\Country;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use rocketfellows\CountryVatFormatValidatorInterface\CountryVatFormatValidators;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryValidatorsNotFoundException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\UnknownInputCountryCodeException;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidatorService;
use rocketfellows\CountryVatNumberFormatValidatorsConfig\CountryVatNumberFormatValidatorsConfigs;
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

    public function testValidatorThrowsExceptionCauseCountryValidatorsNotFound(): void
    {
        $country = $this->getCountryMock(['inputCountryCode' => self::COUNTRY_CODE_TEST_VALUE]);
        $this->countryFactory
            ->expects($this->once())
            ->method('createByCode')
            ->with(self::COUNTRY_CODE_TEST_VALUE)
            ->willReturn($country);
        $this->countryVatNumberFormatValidatorsConfigs
            ->expects($this->once())
            ->method('getCountryValidators')
            ->willReturn(new CountryVatFormatValidators(...[]));

        $this->expectException(CountryValidatorsNotFoundException::class);
        $this->expectExceptionObject(new CountryValidatorsNotFoundException(self::COUNTRY_CODE_TEST_VALUE));

        $this->vatNumberFormatValidatorService->validateCountryVatNumber(
            self::COUNTRY_CODE_TEST_VALUE,
            self::VAT_NUMBER_TEST_VALUE
        );
    }

    private function getCountryMock(array $params = []): MockObject
    {
        /** @var Country|MockObject $mock */
        $mock = $this->createMock(Country::class);
        $mock->method('getAlpha2')->willReturn($params['inputCountryCode'] ?? '');

        return $mock;
    }
}
