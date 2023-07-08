<?php

namespace rocketfellows\CountryVatNumberFormatValidator;

use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryValidatorsNotFoundException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\UnknownInputCountryCodeException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\VatNumberValidatingException;

class VatNumberFormatValidator
{
    private $vatNumberFormatValidatorService;

    public function __construct(VatNumberFormatValidatorService $vatNumberFormatValidatorService)
    {
        $this->vatNumberFormatValidatorService = $vatNumberFormatValidatorService;
    }

    /**
     * @throws CountryCodeEmptyException
     * @throws CountryValidatorsNotFoundException
     * @throws UnknownInputCountryCodeException
     * @throws VatNumberValidatingException
     */
    public function isValid(string $countryCode, string $vatNumber): bool
    {
        return $this->vatNumberFormatValidatorService->validateCountryVatNumber($countryCode, $vatNumber)->isValid();
    }
}
