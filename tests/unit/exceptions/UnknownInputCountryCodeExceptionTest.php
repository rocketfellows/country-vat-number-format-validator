<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\exceptions;

use rocketfellows\CountryVatNumberFormatValidator\exceptions\InputCountryCodeException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\UnknownInputCountryCodeException;
use Throwable;

/**
 * @group country-vat-number-format-validator-exceptions
 */
class UnknownInputCountryCodeExceptionTest extends InputCountryCodeExceptionTest
{
    protected function getExceptionWithFullParameters(string $countryCode, string $message, int $code, ?Throwable $previousException): InputCountryCodeException
    {
        return new UnknownInputCountryCodeException($countryCode, $message, $code, $previousException);
    }

    protected function getExceptionWithOnlyInputCountryCodeParameter(string $countryCode): InputCountryCodeException
    {
        return new UnknownInputCountryCodeException($countryCode);
    }
}
