<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\mocks;

use rocketfellows\CountryVatFormatValidatorInterface\CountryVatFormatValidatorInterface;

class CountryValidVatFormatValidatorMock implements CountryVatFormatValidatorInterface
{
    public function isValid(string $vatNumber): bool
    {
        return true;
    }
}
