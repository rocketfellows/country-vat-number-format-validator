<?php

namespace rocketfellows\CountryVatNumberFormatValidator;

use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException;
use rocketfellows\ISOStandard3166Factory\CountryFactory;

class VatNumberFormatValidatorService
{
    private $countryFactory;

    public function __construct(CountryFactory $countryFactory)
    {
        $this->countryFactory = $countryFactory;
    }

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
