<?php

namespace rocketfellows\CountryVatNumberFormatValidator;

class VatNumberFormatValidationResult
{
    private $isValid;
    private $passedValidatorsClasses;
    private $successfullyValidatorClass;

    /**
     * @param bool $isValid
     * @param string[] $passedValidatorsClasses
     * @param string|null $successfullyValidatorClass
     */
    public function __construct(
        bool $isValid,
        array $passedValidatorsClasses,
        ?string $successfullyValidatorClass = null
    ) {
        $this->isValid = $isValid;
        $this->passedValidatorsClasses = $passedValidatorsClasses;
        $this->successfullyValidatorClass = $successfullyValidatorClass;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return string[]
     */
    public function getPassedValidatorsClasses(): array
    {
        return $this->passedValidatorsClasses;
    }

    public function getSuccessfullyValidatorClass(): ?string
    {
        return $this->successfullyValidatorClass;
    }
}
