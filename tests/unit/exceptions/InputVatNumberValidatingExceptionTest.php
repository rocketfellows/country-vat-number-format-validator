<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\exceptions;

use Exception;
use PHPUnit\Framework\TestCase;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\InputVatNumberValidatingException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\VatNumberFormatValidatorServiceException;
use Throwable;

/**
 * @group country-vat-number-format-validator-exceptions
 */
abstract class InputVatNumberValidatingExceptionTest extends TestCase
{
    abstract protected function getExceptionWithFullParameters(
        string $inputValidatingVatNumber,
        string $message,
        int $code,
        ?Throwable $previousException
    ): InputVatNumberValidatingException;
    abstract protected function getExceptionWithOnlyInputValidatingVatNumberParameter(
        string $inputValidatingVatNumber
    ): InputVatNumberValidatingException;

    /**
     * @dataProvider getInputVatNumberValidatingExceptionProvidedData
     */
    public function testInputVatNumberValidatingExceptionWithFullParameters(
        string $inputValidatingVatNumber,
        string $message,
        int $code,
        ?Throwable $previousException
    ): void {
        $exception = $this->getExceptionWithFullParameters(
            $inputValidatingVatNumber,
            $message,
            $code,
            $previousException
        );

        $this->assertExceptionClassImplementation($exception);
        $this->assertEquals($inputValidatingVatNumber, $exception->getInputValidatingVatNumber());
        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals($code, $exception->getCode());
        $this->assertEquals($previousException, $exception->getPrevious());
    }

    public function getInputVatNumberValidatingExceptionProvidedData(): array
    {
        $previousException = $this->createMock(Throwable::class);

        return [
            'message set, code set, previous exception set' => [
                'inputValidatingVatNumber' => 'foo',
                'message' => 'foo',
                'code' => 1,
                'previousException' => $previousException,
            ],
            'message empty, code set, previous exception set' => [
                'inputValidatingVatNumber' => 'foo',
                'message' => '',
                'code' => 1,
                'previousException' => $previousException,
            ],
            'message set, code set, previous exception not set' => [
                'inputValidatingVatNumber' => 'foo',
                'message' => 'foo',
                'code' => 1,
                'previousException' => null,
            ],
            'message empty, code set, previous exception not set' => [
                'inputValidatingVatNumber' => 'foo',
                'message' => '',
                'code' => 1,
                'previousException' => null,
            ],
            'message empty, code set default, previous exception set' => [
                'inputValidatingVatNumber' => 'foo',
                'message' => '',
                'code' => 0,
                'previousException' => null,
            ],
        ];
    }

    /**
     * @dataProvider getExceptionWithInputValidatingVatNumberProvidedData
     */
    public function testInitExceptionWithOnlyInputValidatingVatNumber(string $inputValidatingVatNumber): void
    {
        $exception = $this->getExceptionWithOnlyInputValidatingVatNumberParameter($inputValidatingVatNumber);

        $this->assertExceptionClassImplementation($exception);
        $this->assertEquals($inputValidatingVatNumber, $exception->getInputValidatingVatNumber());
        $this->assertEmpty($exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function getExceptionWithInputValidatingVatNumberProvidedData(): array
    {
        return [
            [
                'inputValidatingVatNumber' => 'foo',
            ],
            [
                'inputValidatingVatNumber' => 'fooBar',
            ],
            [
                'inputValidatingVatNumber' => '',
            ],
        ];
    }

    private function assertExceptionClassImplementation(Throwable $exception): void
    {
        $this->assertInstanceOf(Exception::class, $exception);
        $this->assertInstanceOf(InputVatNumberValidatingException::class, $exception);
        $this->assertInstanceOf(VatNumberFormatValidatorServiceException::class, $exception);
    }
}
