<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\exceptions;

use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryValidatorsNotFoundException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\InputCountryCodeException;
use Throwable;

/**
 * @group country-vat-number-format-validator-exceptions
 */
class CountryValidatorsNotFoundExceptionTest extends InputCountryCodeExceptionTest
{
    protected function getExceptionWithFullParameters(
        string $countryCode,
        string $message,
        int $code,
        ?Throwable $previousException
    ): InputCountryCodeException {
        return new CountryValidatorsNotFoundException(
            $countryCode,
            $message,
            $code,
            $previousException
        );
    }

    protected function getExceptionWithOnlyInputCountryCodeParameter(string $countryCode): InputCountryCodeException
    {
        return new CountryValidatorsNotFoundException($countryCode);
    }
}
