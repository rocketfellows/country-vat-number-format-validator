<?php

namespace rocketfellows\CountryVatNumberFormatValidator;

use arslanimamutdinov\ISOStandard3166\Country;
use rocketfellows\CountryVatFormatValidatorInterface\CountryVatFormatValidatorInterface;
use rocketfellows\CountryVatFormatValidatorInterface\CountryVatFormatValidators;
use rocketfellows\CountryVatFormatValidatorInterface\exceptions\CountryVatFormatValidationException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryValidatorsNotFoundException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\UnknownInputCountryCodeException;
use rocketfellows\CountryVatNumberFormatValidator\exceptions\VatNumberValidatingException;
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
     * @throws VatNumberValidatingException
     */
    public function validateCountryVatNumber(string $countryCode, string $vatNumber): VatNumberFormatValidationResult
    {
        $validators = $this->getCountryVatNumberFormatValidators($this->getCountryByCode($countryCode));

        $passedValidatorsClasses = [];
        foreach ($validators as $validator) {
            $passedValidatorsClasses[] = get_class($validator);

            if (!$this->isValidVatNumber($validator, $vatNumber)) {
                continue;
            }

            return VatNumberFormatValidationResult::createValidResult($passedValidatorsClasses, get_class($validator));
        }

        return VatNumberFormatValidationResult::createInvalidResult($passedValidatorsClasses);
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
    private function getCountryVatNumberFormatValidators(Country $country): CountryVatFormatValidators
    {
        $validators = $this->countryVatNumberFormatValidatorsConfigs->getCountryValidators($country);

        if ($validators->isEmpty()) {
            throw new CountryValidatorsNotFoundException($country->getAlpha2());
        }

        return $validators;
    }

    /**
     * @throws VatNumberValidatingException
     */
    private function isValidVatNumber(CountryVatFormatValidatorInterface $validator, string $vatNumber): bool
    {
        try {
            return $validator->isValid($vatNumber);
        } catch (CountryVatFormatValidationException $exception) {
            throw new VatNumberValidatingException(
                $vatNumber,
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }
}
