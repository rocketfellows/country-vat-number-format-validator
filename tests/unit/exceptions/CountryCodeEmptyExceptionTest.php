<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\exceptions;

use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\InputCountryCodeException;
use Throwable;

class CountryCodeEmptyExceptionTest extends InputCountryCodeExceptionTest
{
    protected function getExceptionWithFullParameters(
        string $countryCode,
        string $message,
        int $code,
        ?Throwable $previousException
    ): InputCountryCodeException {
        return new CountryCodeEmptyException($countryCode, $message, $code, $previousException);
    }

    protected function getExceptionWithOnlyInputCountryCodeParameter(string $countryCode): InputCountryCodeException
    {
        return new CountryCodeEmptyException($countryCode);
    }
}
