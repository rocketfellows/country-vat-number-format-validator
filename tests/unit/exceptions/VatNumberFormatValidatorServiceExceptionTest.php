<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\exceptions;

use Exception;
use PHPUnit\Framework\TestCase;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\VatNumberFormatValidatorServiceException;
use Throwable;

class VatNumberFormatValidatorServiceExceptionTest extends TestCase
{
    public function testVatNumberFormatValidatorServiceExceptionClassImplementation(): void
    {
        /** @var Throwable $exception */
        $exception = $this->getMockForAbstractClass(VatNumberFormatValidatorServiceException::class);

        $this->assertInstanceOf(Exception::class, $exception);
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
