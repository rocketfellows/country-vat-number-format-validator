<?php

namespace rocketfellows\CountryVatNumberFormatValidator;

use arslanimamutdinov\ISOStandard3166\Country;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\UnknownInputCountryCodeException;
use rocketfellows\ISOStandard3166Factory\CountryFactory;
use rocketfellows\ISOStandard3166Factory\exceptions\EmptyCountryCodeException;
use rocketfellows\ISOStandard3166Factory\exceptions\UnknownCountryCodeException;

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
     * @throws UnknownInputCountryCodeException
     */
    public function validateCountryVatNumber(string $countryCode, string $vatNumber): void
    {
        $country = $this->getCountryByCode($countryCode);
    }

    /**
     * @throws CountryCodeEmptyException
     * @throws UnknownInputCountryCodeException
     */
    private function getCountryByCode(string $countryCode): Country
    {
        try {
            return $this->countryFactory->createByCode($countryCode);
        } catch (EmptyCountryCodeException $exception) {
            throw new CountryCodeEmptyException(
                $countryCode,
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        } catch (UnknownCountryCodeException $exception) {
            throw new UnknownInputCountryCodeException(
                $countryCode,
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }
}
