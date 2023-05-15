<?php

namespace rocketfellows\CountryVatNumberFormatValidator\tests\unit\mocks;

use rocketfellows\CountryVatFormatValidatorInterface\CountryVatFormatValidatorInterface;

class CountryInvalidVatFormatValidatorMock implements CountryVatFormatValidatorInterface
{
    public function isValid(string $vatNumber): bool
    {
        return false;
    }
}
