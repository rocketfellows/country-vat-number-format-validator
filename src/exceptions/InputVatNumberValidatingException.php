<?php

namespace rocketfellows\CountryVatNumberFormatValidator\exceptions;

use Throwable;

class InputVatNumberValidatingException extends VatNumberFormatValidatorServiceException
{
    private $inputValidatingVatNumber;

    public function __construct(
        string $inputValidatingVatNumber,
        string $message = "",
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->inputValidatingVatNumber = $inputValidatingVatNumber;
    }

    public function getInputValidatingVatNumber(): string
    {
        return $this->inputValidatingVatNumber;
    }
}
