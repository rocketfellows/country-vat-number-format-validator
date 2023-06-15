# Configurable country vat number format validator.

![Code Coverage Badge](./badge.svg)

The package provides configurable services for validating country vat number formats.

## Installation.

```shell
composer require rocketfellows/country-vat-number-format-validator
```

## Dependencies.

- https://github.com/rocketfellows/iso-standard-3166-factory v1.0.0
- https://github.com/rocketfellows/country-vat-number-format-validators-config v1.0.0

## References.

The packages below can be connected to the validator right away
because they contain preconfigured validators for the following countries:

- https://github.com/rocketfellows/sk-vat-number-format-validators-config - Slovakia;
- https://github.com/rocketfellows/si-vat-number-format-validators-config - Slovenia;
- https://github.com/rocketfellows/se-vat-number-format-validators-config - Sweden;
- https://github.com/rocketfellows/ru-vat-number-format-validators-config - Russian Federation;
- https://github.com/rocketfellows/ro-vat-number-format-validators-config - Romania;
- https://github.com/rocketfellows/pt-vat-number-format-validators-config - Portugal;
- https://github.com/rocketfellows/pl-vat-number-format-validators-config - Poland;
- https://github.com/rocketfellows/no-vat-number-format-validators-config - Norway;
- https://github.com/rocketfellows/nl-vat-number-format-validators-config - Netherlands;
- https://github.com/rocketfellows/mt-vat-number-format-validators-config - Malta;
- https://github.com/rocketfellows/lv-vat-number-format-validators-config - Latvia;
- https://github.com/rocketfellows/lu-vat-number-format-validators-config - Luxembourg;
- https://github.com/rocketfellows/lt-vat-number-format-validators-config - Lithuania;
- https://github.com/rocketfellows/it-vat-number-format-validators-config - Italy;
- https://github.com/rocketfellows/ie-vat-number-format-validators-config - Ireland;
- https://github.com/rocketfellows/hu-vat-number-format-validators-config - Hungary;
- https://github.com/rocketfellows/hr-vat-number-format-validators-config - Croatia;
- https://github.com/rocketfellows/gr-vat-number-format-validators-config - Greece;
- https://github.com/rocketfellows/gb-vat-number-format-validators-config - United Kingdom;
- https://github.com/rocketfellows/fr-vat-number-format-validators-config - France;
- https://github.com/rocketfellows/fi-vat-number-format-validators-config - Finland;
- https://github.com/rocketfellows/es-vat-number-format-validators-config - Spain;
- https://github.com/rocketfellows/ee-vat-number-format-validators-config - Estonia;
- https://github.com/rocketfellows/dk-vat-number-format-validators-config - Denmark;
- https://github.com/rocketfellows/de-vat-number-format-validators-config - Germany;
- https://github.com/rocketfellows/cz-vat-number-format-validators-config - Czech Republic;
- https://github.com/rocketfellows/cy-vat-number-format-validators-config - Cyprus;
- https://github.com/rocketfellows/che-vat-number-format-validators-config - Switzerland;
- https://github.com/rocketfellows/bg-vat-number-format-validators-config - Bulgaria;
- https://github.com/rocketfellows/be-vat-number-format-validators-config - Belgium;
- https://github.com/rocketfellows/at-vat-number-format-validators-config - Austria;

## Interface for validating country vat number format.

Service for checking the vat number format for the country:
**_rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidatorService_**

Function to check if the country vat number format is correct:
**_rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidatorService::validateCountryVatNumber_**

Input parameters:
- **_countryCode_** - string - country code in ISO 3166 standard (processable formats: alpha2, alpha3, numeric code);
- **_vatNumber_** - string - vat number;

Throwable exceptions:
- **_rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryCodeEmptyException_** - when **_countryCode_** is empty string;
- **_rocketfellows\CountryVatNumberFormatValidator\exceptions\UnknownInputCountryCodeException_** - when **_CountryFactory_** cant find country according to given **_countryCode_**;
- **_rocketfellows\CountryVatNumberFormatValidator\exceptions\CountryValidatorsNotFoundException_** - when service not found validator for given country;
- **_rocketfellows\CountryVatNumberFormatValidator\exceptions\VatNumberValidatingException_** - when found validator for country throws any exception in process;

Return value is instance of **_rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidationResult_**.

**_VatNumberFormatValidationResult_** description:
- **_createInvalidResult_** - static factory function for create invalid validation result, returns instance of **_VatNumberFormatValidationResult_**;
- **_createValidResult_** - static factory function for create valid validation result, returns instance of **_VatNumberFormatValidationResult_**;
- **_isValid_** - returns true if vat number is valid for given country, if vat number is invalid returns false;
- **_getPassedValidatorsClasses_** - returns array of classes (array of string), which was passed during validation process;
- **_getSuccessfullyValidatorClass_** - if vat number is valid for given country, returns validator class which succeed validation;

## Usage example of preconfigured validators for countries.

To use the preconfigured validators for a country, you need to install the appropriate package from the list above from section "References".

Example of instantiating **_VatNumberFormatValidatorService_**:
```php
$validatorService = new VatNumberFormatValidatorService(
    new CountryVatNumberFormatValidatorsConfigs(
        new SKVatNumberFormatValidatorsConfig(),
        new SIVatNumberFormatValidatorsConfig(),
        new SEVatNumberFormatValidatorsConfig(),
        new RUVatNumberFormatValidatorsConfig(),
        new ROVatNumberFormatValidatorsConfig(),
        new PTVatNumberFormatValidatorsConfig(),
        new PLVatNumberFormatValidatorsConfig(),
        new NOVatNumberFormatValidatorsConfig(),
        new NLVatNumberFormatValidatorsConfig(),
        new MTVatNumberFormatValidatorsConfig(),
        new LVVatNumberFormatValidatorsConfig(),
        new LUVatNumberFormatValidatorsConfig(),
        new LTVatNumberFormatValidatorsConfig(),
        new ITVatNumberFormatValidatorsConfig(),
        new IEVatNumberFormatValidatorsConfig(),
        new HUVatNumberFormatValidatorsConfig(),
        new HRVatNumberFormatValidatorsConfig(),
        new GRVatNumberFormatValidatorsConfig(),
        new GBVatNumberFormatValidatorsConfig(),
        new FRVatNumberFormatValidatorsConfig(),
        new FIVatNumberFormatValidatorsConfig(),
        new ESVatNumberFormatValidatorsConfig(),
        new EEVatNumberFormatValidatorsConfig(),
        new DKVatNumberFormatValidatorsConfig(),
        new DEVatNumberFormatValidatorsConfig(),
        new CZVatNumberFormatValidatorsConfig(),
        new CYVatNumberFormatValidatorsConfig(),
        new CHEVatNumberFormatValidatorsConfig(),
        new BGVatNumberFormatValidatorsConfig(),
        new BEVatNumberFormatValidatorsConfig(),
        new ATVatNumberFormatValidatorsConfig()
    ),
    new CountryFactory()
);
```

### Valid country vat number format examples.

#### Austria vat number.

```php
// country code case-insensitive
$result = $validatorService->validateCountryVatNumber('at', 'ATU62181819');

var_dump($result);
```

Validation result:

```php
class rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidationResult#101 (3) {
  private $isValid =>
  bool(true)
  private $passedValidatorsClasses =>
  array(1) {
    [0] =>
    string(55) "rocketfellows\ATVatFormatValidator\ATVatFormatValidator"
  }
  private $successfullyValidatorClass =>
  string(55) "rocketfellows\ATVatFormatValidator\ATVatFormatValidator"
}
```

#### Germany vat number.

```php
// country code case-insensitive
$result = $validatorService->validateCountryVatNumber('de', 'DE282308599');

var_dump($result);
```

Validation result:

```php
class rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidationResult#101 (3) {
  private $isValid =>
  bool(true)
  private $passedValidatorsClasses =>
  array(1) {
    [0] =>
    string(55) "rocketfellows\DEVatFormatValidator\DEVatFormatValidator"
  }
  private $successfullyValidatorClass =>
  string(55) "rocketfellows\DEVatFormatValidator\DEVatFormatValidator"
}
```

### Invalid country vat number format examples.

#### Austria vat number.

```php
// country code case-insensitive
$result = $validatorService->validateCountryVatNumber('at', 'foo');

var_dump($result);
```

Validation result:

```php
class rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidationResult#99 (3) {
  private $isValid =>
  bool(false)
  private $passedValidatorsClasses =>
  array(1) {
    [0] =>
    string(55) "rocketfellows\ATVatFormatValidator\ATVatFormatValidator"
  }
  private $successfullyValidatorClass =>
  NULL
}
```

#### Germany vat number.

```php
// country code case-insensitive
$result = $validatorService->validateCountryVatNumber('de', 'foo');

var_dump($result);
```

Validation result:

```php
class rocketfellows\CountryVatNumberFormatValidator\VatNumberFormatValidationResult#99 (3) {
  private $isValid =>
  bool(false)
  private $passedValidatorsClasses =>
  array(1) {
    [0] =>
    string(55) "rocketfellows\DEVatFormatValidator\DEVatFormatValidator"
  }
  private $successfullyValidatorClass =>
  NULL
}
```

## Contributing.

Welcome to pull requests. If there is a major changes, first please open an issue for discussion.

Please make sure to update tests as appropriate.