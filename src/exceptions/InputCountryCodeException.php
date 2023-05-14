<?php

namespace rocketfellows\CountryVatNumberFormatValidator\exceptions;

use Throwable;

abstract class InputCountryCodeException extends VatNumberFormatValidatorServiceException
{
    private $inputCountryCode;

    public function __construct(
        string $inputCountryCode,
        string $message = "",
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->inputCountryCode = $inputCountryCode;
    }

    public function getInputCountryCode(): string
    {
        return $this->inputCountryCode;
    }
}
