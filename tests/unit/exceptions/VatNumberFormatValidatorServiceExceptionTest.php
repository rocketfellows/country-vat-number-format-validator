<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\exceptions;

use Exception;
use PHPUnit\Framework\TestCase;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\VatNumberFormatValidatorServiceException;
use Throwable;

/**
 * @group country-vat-number-format-validator-exceptions
 */
class VatNumberFormatValidatorServiceExceptionTest extends TestCase
{
    public function testVatNumberFormatValidatorServiceExceptionClassImplementation(): void
    {
        /** @var Throwable $exception */
        $exception = $this->getMockForAbstractClass(VatNumberFormatValidatorServiceException::class);

        $this->assertInstanceOf(Exception::class, $exception);
    }

    /**
     * @dataProvider getVatNumberFormatValidatorServiceExceptionWithMessageAndCodeProvidedData
     */
    public function testVatNumberFormatValidatorServiceExceptionWithMessageAndCodeSet(
        string $message,
        int $code
    ): void {
        /** @var Throwable $exception */
        $exception = $this->getMockForAbstractClass(
            VatNumberFormatValidatorServiceException::class,
            [
                $message,
                $code
            ]
        );

        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals($code, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function getVatNumberFormatValidatorServiceExceptionWithMessageAndCodeProvidedData(): array
    {
        return [
            [
                'message' => 'foo',
                'code' => 1,
            ],
            [
                'message' => 'fooBar',
                'code' => 2,
            ],
            [
                'message' => 'bar',
                'code' => 0,
            ],
        ];
    }

    /**
     * @dataProvider getVatNumberFormatValidatorServiceExceptionWithOnlyMessageProvidedData
     */
    public function testVatNumberFormatValidatorServiceExceptionWithOnlyMessageSet(
        string $message
    ): void {
        /** @var Throwable $exception */
        $exception = $this->getMockForAbstractClass(
            VatNumberFormatValidatorServiceException::class,
            [
                $message,
            ]
        );

        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    public function getVatNumberFormatValidatorServiceExceptionWithOnlyMessageProvidedData(): array
    {
        return [
            [
                'message' => 'foo',
            ],
            [
                'message' => 'bar',
            ],
            [
                'message' => '',
            ],
        ];
    }

    public function testVatNumberFormatValidatorServiceExceptionDefaultInit(): void
    {
        /** @var Throwable $exception */
        $exception = $this->getMockForAbstractClass(VatNumberFormatValidatorServiceException::class);

        $this->assertEmpty($exception->getMessage());
        $this->assertEquals(0, $exception->getCode());
        $this->assertNull($exception->getPrevious());
    }

    /**
     * @dataProvider getExceptionWithAllParamsProvidedData
     */
    public function testInitExceptionWithAllParams(
        string $message,
        int $code,
        ?Throwable $previousException
    ): void {
        /** @var Throwable $exception */
        $exception = $this->getMockForAbstractClass(
            VatNumberFormatValidatorServiceException::class,
            [
                $message,
                $code,
                $previousException
            ]
        );

        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals($code, $exception->getCode());
        $this->assertEquals($previousException, $exception->getPrevious());
    }

    public function getExceptionWithAllParamsProvidedData(): array
    {
        $previousException = $this->createMock(Throwable::class);

        return [
            'message set, code set, previous exception set' => [
                'message' => 'foo',
                'code' => 1,
                'previousException' => $previousException,
            ],
            'message set, code set, previous exception not set' => [
                'message' => 'foo',
                'code' => 1,
                'previousException' => null,
            ],
        ];
    }
}
