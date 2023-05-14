<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\exceptions;

use rocketfellows\CountryVatNumberFormatValidator\exceptions\InputVatNumberValidatingException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\VatNumberValidatingException;
use Throwable;

class VatNumberValidatingExceptionTest extends InputVatNumberValidatingExceptionTest
{
    protected function getExceptionWithFullParameters(
        string $inputValidatingVatNumber,
        string $message,
        int $code,
        ?Throwable $previousException
    ): InputVatNumberValidatingException {
        return new VatNumberValidatingException(
            $inputValidatingVatNumber,
            $message,
            $code,
            $previousException
        );
    }

    protected function getExceptionWithOnlyInputValidatingVatNumberParameter(string $inputValidatingVatNumber): InputVatNumberValidatingException
    {
        return new VatNumberValidatingException($inputValidatingVatNumber);
    }
}
