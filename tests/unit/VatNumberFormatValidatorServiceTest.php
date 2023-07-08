<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit;

use arslanimamutdinov\ISOStandard3166\Country;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use rocketfellows\CountryVatFormatValidatorInterface\CountryVatFormatValidatorInterface;
use rocketfellows\CountryVatFormatValidatorInterface\CountryVatFormatValidators;
use rocketfellows\CountryVatFormatValidatorInterface\exceptions\CountryVatFormatValidationException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryValidatorsNotFoundException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\UnknownInputCountryCodeException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\VatNumberValidatingException;
use rocketfellows\CountryVatNumberFormatValidator\tests\unit\mocks\CountryInvalidVatFormatValidatorMock;
use rocketfellows\CountryVatNumberFormatValidator\tests\unit\mocks\CountryValidVatFormatValidatorMock;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidationResult;
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

    /**
     * @dataProvider getValidationResultProvidedData
     */
    public function testValidationResult(
        string $countryCode,
        MockObject $country,
        CountryVatFormatValidators $validators,
        VatNumberFormatValidationResult $expectedValidationResult
    ): void {
        $this->countryFactory
            ->expects($this->once())
            ->method('createByCode')
            ->with(self::COUNTRY_CODE_TEST_VALUE)
            ->willReturn($country);

        $this->countryVatNumberFormatValidatorsConfigs
            ->expects($this->once())
            ->method('getCountryValidators')
            ->with($country)
            ->willReturn($validators);

        $this->assertEquals(
            $expectedValidationResult,
            $this->vatNumberFormatValidatorService->validateCountryVatNumber(
                $countryCode,
                self::VAT_NUMBER_TEST_VALUE
            )
        );
    }

    public function getValidationResultProvidedData(): array
    {
        return [
            'one validator in config and returns invalid result' => [
                'countryCode' => self::COUNTRY_CODE_TEST_VALUE,
                'country' => $this->getCountryMock(['inputCountryCode' => self::COUNTRY_CODE_TEST_VALUE,]),
                'validators' => new CountryVatFormatValidators(
                    new CountryInvalidVatFormatValidatorMock(),
                ),
                'expectedValidationResult' => new VatNumberFormatValidationResult(
                    false,
                    [
                        CountryInvalidVatFormatValidatorMock::class,
                    ]
                ),
            ],
            '4 validators in config, all validators returns invalid result' => [
                'countryCode' => self::COUNTRY_CODE_TEST_VALUE,
                'country' => $this->getCountryMock(['inputCountryCode' => self::COUNTRY_CODE_TEST_VALUE,]),
                'validators' => new CountryVatFormatValidators(
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                ),
                'expectedValidationResult' => new VatNumberFormatValidationResult(
                    false,
                    [
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                    ]
                ),
            ],
            '10 validators in config, all validators returns invalid result' => [
                'countryCode' => self::COUNTRY_CODE_TEST_VALUE,
                'country' => $this->getCountryMock(['inputCountryCode' => self::COUNTRY_CODE_TEST_VALUE,]),
                'validators' => new CountryVatFormatValidators(
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                ),
                'expectedValidationResult' => new VatNumberFormatValidationResult(
                    false,
                    [
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                    ]
                ),
            ],
            '2 validators in config, first validator returns valid result' => [
                'countryCode' => self::COUNTRY_CODE_TEST_VALUE,
                'country' => $this->getCountryMock(['inputCountryCode' => self::COUNTRY_CODE_TEST_VALUE,]),
                'validators' => new CountryVatFormatValidators(
                    new CountryValidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                ),
                'expectedValidationResult' => new VatNumberFormatValidationResult(
                    true,
                    [
                        CountryValidVatFormatValidatorMock::class,
                    ],
                    CountryValidVatFormatValidatorMock::class
                ),
            ],
            '2 validators in config, second validator returns valid result' => [
                'countryCode' => self::COUNTRY_CODE_TEST_VALUE,
                'country' => $this->getCountryMock(['inputCountryCode' => self::COUNTRY_CODE_TEST_VALUE,]),
                'validators' => new CountryVatFormatValidators(
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryValidVatFormatValidatorMock(),
                ),
                'expectedValidationResult' => new VatNumberFormatValidationResult(
                    true,
                    [
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryValidVatFormatValidatorMock::class,
                    ],
                    CountryValidVatFormatValidatorMock::class
                ),
            ],
            '3 validators in config, third validator returns valid result' => [
                'countryCode' => self::COUNTRY_CODE_TEST_VALUE,
                'country' => $this->getCountryMock(['inputCountryCode' => self::COUNTRY_CODE_TEST_VALUE,]),
                'validators' => new CountryVatFormatValidators(
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryValidVatFormatValidatorMock(),
                ),
                'expectedValidationResult' => new VatNumberFormatValidationResult(
                    true,
                    [
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryValidVatFormatValidatorMock::class,
                    ],
                    CountryValidVatFormatValidatorMock::class
                ),
            ],
            '10 validators in config, last validator returns valid result' => [
                'countryCode' => self::COUNTRY_CODE_TEST_VALUE,
                'country' => $this->getCountryMock(['inputCountryCode' => self::COUNTRY_CODE_TEST_VALUE,]),
                'validators' => new CountryVatFormatValidators(
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryValidVatFormatValidatorMock(),
                ),
                'expectedValidationResult' => new VatNumberFormatValidationResult(
                    true,
                    [
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryValidVatFormatValidatorMock::class,
                    ],
                    CountryValidVatFormatValidatorMock::class
                ),
            ],
            '10 validators in config, 5th validator returns valid result' => [
                'countryCode' => self::COUNTRY_CODE_TEST_VALUE,
                'country' => $this->getCountryMock(['inputCountryCode' => self::COUNTRY_CODE_TEST_VALUE,]),
                'validators' => new CountryVatFormatValidators(
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryValidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                    new CountryInvalidVatFormatValidatorMock(),
                ),
                'expectedValidationResult' => new VatNumberFormatValidationResult(
                    true,
                    [
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryInvalidVatFormatValidatorMock::class,
                        CountryValidVatFormatValidatorMock::class,
                    ],
                    CountryValidVatFormatValidatorMock::class
                ),
            ],
        ];
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
            ->willReturn($this->getCountryVatFormatValidatorsMock(['isEmpty' => true,]));

        $this->expectException(CountryValidatorsNotFoundException::class);
        $this->expectExceptionObject(new CountryValidatorsNotFoundException(self::COUNTRY_CODE_TEST_VALUE));

        $this->vatNumberFormatValidatorService->validateCountryVatNumber(
            self::COUNTRY_CODE_TEST_VALUE,
            self::VAT_NUMBER_TEST_VALUE
        );
    }

    public function testValidatorThrowsExceptionCauseCountryVatFormatValidatorThrowsException(): void
    {
        $country = $this->getCountryMock(['inputCountryCode' => self::COUNTRY_CODE_TEST_VALUE]);
        $this->countryFactory
            ->expects($this->once())
            ->method('createByCode')
            ->with(self::COUNTRY_CODE_TEST_VALUE)
            ->willReturn($country);

        /** @var CountryVatFormatValidatorInterface|MockObject $validator */
        $validator = $this->createMock(CountryVatFormatValidatorInterface::class);
        $validatorException = $this->createMock(CountryVatFormatValidationException::class);
        $validator
            ->expects($this->once())
            ->method('isValid')
            ->with(self::VAT_NUMBER_TEST_VALUE)
            ->willThrowException($validatorException);

        $this->countryVatNumberFormatValidatorsConfigs
            ->expects($this->once())
            ->method('getCountryValidators')
            ->with($country)
            ->willReturn(new CountryVatFormatValidators($validator));

        $this->expectException(VatNumberValidatingException::class);
        $this->expectExceptionObject(
            new VatNumberValidatingException(
                self::VAT_NUMBER_TEST_VALUE,
                $validatorException->getMessage(),
                $validatorException->getCode(),
                $validatorException
            )
        );

        $this->vatNumberFormatValidatorService->validateCountryVatNumber(
            self::COUNTRY_CODE_TEST_VALUE,
            self::VAT_NUMBER_TEST_VALUE
        );
    }

    private function getCountryVatFormatValidatorsMock(array $params = []): MockObject
    {
        $mock = $this->createMock(CountryVatFormatValidators::class);
        $mock->method('isEmpty')->willReturn($params['isEmpty'] ?? true);

        return $mock;
    }

    private function getCountryMock(array $params = []): MockObject
    {
        /** @var Country|MockObject $mock */
        $mock = $this->createMock(Country::class);
        $mock->method('getAlpha2')->willReturn($params['inputCountryCode'] ?? '');

        return $mock;
    }
}
