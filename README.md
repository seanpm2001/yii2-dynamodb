# Yii2 DynamoDB Cache and Queue Driver Implementation

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/:package_name.svg?style=flat-square)](https://packagist.org/packages/spatie/:package_name)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/:package_name/run-tests?label=tests)](https://github.com/spatie/:package_name/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/:package_name.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/:package_name)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/:package_name.svg?style=flat-square)](https://packagist.org/packages/spatie/:package_name)

Easily use DynamoDB as a queue or cache using this package.    

## Installation

You can install the package via composer:

```bash
composer require mccallister/yii2-dynamodb
```

## Usage

Configure your cache component to use DynamoDB:

```php
return [
    'bootstrap' => [
        'cache', // The component registers own console commands
    ],
    'components' => [
        'cache' => [
            'class' => \mccallister\dynamodb\cache\driver\Cache::class,
            'table' => 'my-app-cache-table',
            'key' => '<key>', // optional: default to AWS_ACCESS_KEY env var
            'secret' => '<secret>', // optional: default to AWS_SECRET_KEY env var
            'region' => '<region>', // optional: default to AWS_REGION env var
        ],
    ],
];
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email jason@craftcms.com instead of using the issue tracker.

## Credits

- [Jason McCallister](https://github.com/jasonmccallister)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
