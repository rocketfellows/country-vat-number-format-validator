<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\exceptions;

use PHPUnit\Framework\TestCase;
use Throwable;

class InputCountryCodeExceptionTest extends TestCase
{
    /**
     * @dataProvider getInputCountryCodeExceptionProvidedData
     */
    public function testInputCountryCodeExceptionWithFullParameters(
        string $countryCode,
        string $message,
        int $code,
        ?Throwable $previousException
    ): void {
        /** @var Throwable $exception */
        $exception = $this->getMockForAbstractClass(
            InputCountryCodeException::class,
            [
                $countryCode,
                $message,
                $code,
                $previousException
            ]
        );

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
        /** @var Throwable $exception */
        $exception = $this->getMockForAbstractClass(
            InputCountryCodeException::class,
            [
                $countryCode,
            ]
        );

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
}
