<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\exceptions;

use PHPUnit\Framework\TestCase;
use Throwable;

class InputCountryCodeExceptionTest extends TestCase
{
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
