<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\exceptions;

use Exception;
use PHPUnit\Framework\TestCase;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\InputCountryCodeException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\VatNumberFormatValidatorServiceException;
use Throwable;

/**
 * @group country-vat-number-format-validator-exceptions
 */
abstract class InputCountryCodeExceptionTest extends TestCase
{
    abstract protected function getExceptionWithFullParameters(
        string $countryCode,
        string $message,
        int $code,
        ?Throwable $previousException
    ): InputCountryCodeException;
    abstract protected function getExceptionWithOnlyInputCountryCodeParameter(
        string $countryCode
    ): InputCountryCodeException;

    /**
     * @dataProvider getInputCountryCodeExceptionProvidedData
     */
    public function testInputCountryCodeExceptionWithFullParameters(
        string $countryCode,
        string $message,
        int $code,
        ?Throwable $previousException
    ): void {
        $exception = $this->getExceptionWithFullParameters($countryCode, $message, $code, $previousException);

        $this->assertExceptionClassImplementation($exception);
        $this->assertEquals($countryCode, $exception->getInputCountryCode());
        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals($code, $exception->getCode());
        $this->assertEquals($previousException, $exception->getPrevious());
    }

    public function getInputCountryCodeExceptionProvidedData(): array
    {
        $previousException = $this->createMock(Throwable::class);

        return [
            'message set, code set, previous exception set' => [
                'countryCode' => 'foo',
                'message' => 'foo',
                'code' => 1,
                'previousException' => $previousException,
            ],
            'message empty, code set, previous exception set' => [
                'countryCode' => 'foo',
                'message' => '',
                'code' => 1,
                'previousException' => $previousException,
            ],
            'message set, code set, previous exception not set' => [
                'countryCode' => 'foo',
                'message' => 'foo',
                'code' => 1,
                'previousException' => null,
            ],
            'message empty, code set, previous exception not set' => [
                'countryCode' => 'foo',
                'message' => '',
                'code' => 1,
                'previousException' => null,
            ],
            'message empty, code set default, previous exception set' => [
                'countryCode' => 'foo',
                'message' => '',
                'code' => 0,
                'previousException' => null,
            ],
        ];
    }

    /**
     * @dataProvider getExceptionWithInputCountryCodeProvidedData
     */
    public function testInitExceptionWithOnlyInputCountryCode(string $countryCode): void
    {
        $exception = $this->getExceptionWithOnlyInputCountryCodeParameter($countryCode);

        $this->assertExceptionClassImplementation($exception);
        $this->assertEquals($countryCode, $exception->getInputCountryCode());
        $this->assertEmpty($exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function getExceptionWithInputCountryCodeProvidedData(): array
    {
        return [
            [
                'countryCode' => 'foo',
            ],
            [
                'countryCode' => 'fooBar',
            ],
            [
                'countryCode' => '',
            ],
        ];
    }

    private function assertExceptionClassImplementation(Throwable $exception): void
    {
        $this->assertInstanceOf(Exception::class, $exception);
        $this->assertInstanceOf(InputCountryCodeException::class, $exception);
        $this->assertInstanceOf(VatNumberFormatValidatorServiceException::class, $exception);
    }
}
