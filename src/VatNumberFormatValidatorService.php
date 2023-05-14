<?php

namespace rocketfellows\CountryVatNumberFormatValidator;

use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException;

class VatNumberFormatValidatorService
{
    /**
     * TODO: implement
     * @throws CountryCodeEmptyException
     */
    public function validateCountryVatNumber(string $countryCode, string $vatNumber): void
    {
        $this->validateInputCountryCode($countryCode);
    }

    /**
     * @throws CountryCodeEmptyException
     */
    private function validateInputCountryCode(string $countryCode): void
    {
        if (empty($countryCode)) {
            throw new CountryCodeEmptyException($countryCode);
        }
    }
}
