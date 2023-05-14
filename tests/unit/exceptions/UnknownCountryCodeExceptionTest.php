<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\exceptions;

use Throwable;

class UnknownCountryCodeExceptionTest extends InputCountryCodeExceptionTest
{
    protected function getExceptionWithFullParameters(string $countryCode, string $message, int $code, ?Throwable $previousException): Throwable
    {
        return new UnknownCountryCodeException($countryCode, $message, $code, $previousException);
    }

    protected function getExceptionWithOnlyInputCountryCodeParameter(string $countryCode): Throwable
    {
        return new UnknownCountryCodeException($countryCode);
    }
}
