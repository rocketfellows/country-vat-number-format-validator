<?php

namespace rocketfellows\CountryVatNumberFormatValidator;

class VatNumberFormatValidationResult
{
    private $isValid;
    private $passedValidatorsClasses;
    private $successfullyValidatorClass;

    public function __construct(
        bool $isValid,
        array $passedValidatorsClasses,
        ?string $successfullyValidatorClass = null
    ) {
        $this->isValid = $isValid;
        $this->passedValidatorsClasses = $passedValidatorsClasses;
        $this->successfullyValidatorClass = $successfullyValidatorClass;
    }
}
