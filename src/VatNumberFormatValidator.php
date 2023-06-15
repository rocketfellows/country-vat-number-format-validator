<?php

namespace rocketfellows\CountryVatNumberFormatValidator;

class VatNumberFormatValidator
{
    private $vatNumberFormatValidatorService;

    public function __construct(VatNumberFormatValidatorService $vatNumberFormatValidatorService)
    {
        $this->vatNumberFormatValidatorService = $vatNumberFormatValidatorService;
    }
}
