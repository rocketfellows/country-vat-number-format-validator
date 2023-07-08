<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryValidatorsNotFoundException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\UnknownInputCountryCodeException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\VatNumberValidatingException;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidationResult;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidator;
use rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidatorService;
use Throwable;

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

    public function testCountryVatNumberIsNotValid(): void
    {
        $validationResult = $this->getVatNumberFormatValidationResultMock();
        $validationResult
            ->expects($this->once())
            ->method('isValid')
            ->willReturn(false);

        $this->vatNumberFormatValidatorService
            ->expects($this->once())
            ->method('validateCountryVatNumber')
            ->willReturn($validationResult);

        $this->assertFalse(
            $this->vatNumberFormatValidator->isValid(
                self::COUNTRY_CODE_TEST_VALUE,
                self::VAT_NUMBER_TEST_VALUE
            )
        );
    }

    /**
     * @dataProvider getHandlingValidationExceptionsProvidedData
     */
    public function testHandlingValidationExceptions(Throwable $thrownException, string $expectedExceptionClass): void
    {
        $this->vatNumberFormatValidatorService
            ->expects($this->once())
            ->method('validateCountryVatNumber')
            ->willThrowException($thrownException);

        $this->expectException($expectedExceptionClass);

        $this->vatNumberFormatValidator->isValid(
            self::COUNTRY_CODE_TEST_VALUE,
            self::VAT_NUMBER_TEST_VALUE
        );
    }

    public function getHandlingValidationExceptionsProvidedData(): array
    {
        return [
            'thrown CountryCodeEmptyException' => [
                'thrownException' => $this->createMock(CountryCodeEmptyException::class),
                'expectedExceptionClass' => CountryCodeEmptyException::class,
            ],
            'thrown CountryValidatorsNotFoundException' => [
                'thrownException' => $this->createMock(CountryValidatorsNotFoundException::class),
                'expectedExceptionClass' => CountryValidatorsNotFoundException::class,
            ],
            'thrown UnknownInputCountryCodeException' => [
                'thrownException' => $this->createMock(UnknownInputCountryCodeException::class),
                'expectedExceptionClass' => UnknownInputCountryCodeException::class,
            ],
            'thrown VatNumberValidatingException' => [
                'thrownException' => $this->createMock(VatNumberValidatingException::class),
                'expectedExceptionClass' => VatNumberValidatingException::class,
            ],
            'thrown Throwable' => [
                'thrownException' => $this->createMock(Throwable::class),
                'expectedExceptionClass' => Throwable::class,
            ],
        ];
    }

    private function getVatNumberFormatValidationResultMock(): MockObject
    {
        /** @var VatNumberFormatValidationResult|MockObject $mock */
        $mock = $this->createMock(VatNumberFormatValidationResult::class);

        return $mock;
    }
}
