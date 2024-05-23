# Confirmations for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kodeksoff/confirmatio.svg?style=flat-square)](https://packagist.org/packages/kodeksoff/confirmatio)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/kodeksoff/confirmatio/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/kodeksoff/confirmatio/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/kodeksoff/confirmatio/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/kodeksoff/confirmatio/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/kodeksoff/confirmatio.svg?style=flat-square)](https://packagist.org/packages/kodeksoff/confirmatio)

This package simplifies the creation of functionality for confirming a phone number or email. Uses Laravel's built-in mechanisms to limit attempts, protecting against abuse and increasing the security of your application. The package is easily integrated into existing Laravel projects, providing flexible settings for working with various confirmation delivery channels, such as SMS, Email and other.

## Installation

You can install the package via composer:

```bash
composer require kodeksoff/confirmatio
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="confirmatio-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="confirmatio-config"
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [kodeksoff](https://github.com/kodeksoff)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
