<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\exceptions;

use PHPUnit\Framework\TestCase;
use Throwable;

class VatNumberFormatValidatorServiceExceptionTest extends TestCase
{
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
