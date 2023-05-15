<?php

namespace rocketfellows\CountryVatNumberFormatValidator;

use arslanimamutdinov\ISOStandard3166\Country;
use rocketfellows\CountryVatFormatValidatorInterface\CountryVatFormatValidators;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryValidatorsNotFoundException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\UnknownInputCountryCodeException;
use rocketfellows\CountryVatNumberFormatValidatorsConfig\CountryVatNumberFormatValidatorsConfigs;
use rocketfellows\ISOStandard3166Factory\CountryFactory;
use rocketfellows\ISOStandard3166Factory\exceptions\EmptyCountryCodeException;
use rocketfellows\ISOStandard3166Factory\exceptions\UnknownCountryCodeException;

class VatNumberFormatValidatorService
{
    private $countryVatNumberFormatValidatorsConfigs;
    private $countryFactory;

    public function __construct(
        CountryVatNumberFormatValidatorsConfigs $countryVatNumberFormatValidatorsConfigs,
        CountryFactory $countryFactory
    ) {
        $this->countryVatNumberFormatValidatorsConfigs = $countryVatNumberFormatValidatorsConfigs;
        $this->countryFactory = $countryFactory;
    }

    /**
     * TODO: implement
     * @throws CountryCodeEmptyException
     * @throws UnknownInputCountryCodeException
     * @throws CountryValidatorsNotFoundException
     */
    public function validateCountryVatNumber(string $countryCode, string $vatNumber): void
    {
        $country = $this->getCountryByCode($countryCode);
        $this->getCountryVatNumberFormatValidators($country);
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

    /**
     * @throws CountryValidatorsNotFoundException
     */
    private function getCountryVatNumberFormatValidators(Country $country): void
    {
        $validators = $this->countryVatNumberFormatValidatorsConfigs->getCountryValidators($country);

        if ($validators->isEmpty()) {
            throw new CountryValidatorsNotFoundException($country->getAlpha2());
        }
    }
}
