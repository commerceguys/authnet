# Authorize.net PHP SDK [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/commerceguys/authnet/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/commerceguys/authnet/?branch=master) [![Build Status](https://travis-ci.org/commerceguys/authnet.svg?branch=master)](https://travis-ci.org/commerceguys/authnet) [![Code Coverage](https://scrutinizer-ci.com/g/commerceguys/authnet/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/commerceguys/authnet/?branch=master)

A PHP SDK for Authorize.net, using Guzzle.

## Why not the official Authorize.net PHP SDK?

* Currently https://github.com/AuthorizeNet/sdk-php is licensed under a proprietary license.
* It is not PSR-4.
* Too many dependencies.

## Dependencies

PHP version >= 5.5.0 is required.

The following PHP extensions are required:
* json
* simplexml
* xmlwrite

This library also uses Guzzle 6.

## Testing

### PHPUnit

Run `composer test`, or `./vendor/bin/phpunit -c phpunit.xml.dist`

### Test Credit Card Numbercs

| Card Type                  | Card Number      |
|----------------------------|------------------|
| American Express Test Card | 370000000000002  |
| Discover Test Card         | 6011000000000012 |
| Visa Test Card             | 4007000000027    |
| Second Visa Test Card      | 4012888818888    |
| JCB                        | 3088000000000017 |
| Diners Club/ Carte Blanche | 38000000000006   |


## License

See the LICENSE file.