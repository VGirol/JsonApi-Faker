# JsonApi-Faker

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Infection MSI][ico-mutation]][link-mutation]
[![Total Downloads][ico-downloads]][link-downloads]

This package provides a set of factories to build fake data using the [JSON:API specification](https://jsonapi.org/).

## Technologies

- PHP 7.2+

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require-dev": {
        "vgirol/jsonapi-faker": "dev-master"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplified by using the following command:

```sh
composer require vgirol/jsonapi-faker
```

## Usage

First create a faker generator.

```php
use VGirol\JsonApiFaker\Generator as JsonApiFaker;

$faker = new JsonApiFaker;
```

Then create a factory.

```php
$factory = $faker->resourceObject();
```

Next you can fill the factory ...

```php
$factory->setResourceType('test')
        ->setId('1')
        ->setAttributes([
            'attr1' => 'value1',
            'attr2' => 'value2'
        ])
        ->setMeta([
            'key1' => 'meta1'
        ])
        ->addLink('self', 'url');
```

... or generate a fake.

```php
$factory->fake();
```

Finally export as an array or as JSON.

```php
$array = $factory->toArray();
$json = $factory->toJson();
```

All these instructions can be chained.

```php
use VGirol\JsonApiFaker\Generator as JsonApiFaker;

$json = new JsonApiFaker()
    ->resourceObject()
    ->fake()
    ->toJson();
```

## Documentation

The API documentation is available in XHTML format at the url [http://jsonapi-faker.girol.fr/docs/ref/index.html](http://jsonapi-faker.girol.fr/docs/ref/index.html).

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email [vincent@girol.fr](mailto:vincent@girol.fr) instead of using the issue tracker.

## Credits

- [Girol Vincent][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/VGirol/JsonApi-Faker.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/VGirol/JsonApi-Faker/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/VGirol/JsonApi-Faker.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/VGirol/JsonApi-Faker.svg?style=flat-square
[ico-mutation]: https://img.shields.io/endpoint?style=flat-square&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FVGirol%2FJsonApi-Faker%2Fmaster
[ico-downloads]: https://img.shields.io/packagist/dt/VGirol/JsonApi-Faker.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/VGirol/JsonApi-Faker
[link-travis]: https://travis-ci.org/VGirol/JsonApi-Faker
[link-scrutinizer]: https://scrutinizer-ci.com/g/VGirol/JsonApi-Faker/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/VGirol/JsonApi-Faker
[link-downloads]: https://packagist.org/packages/VGirol/JsonApi-Faker
[link-author]: https://github.com/VGirol
[link-mutation]: https://dashboard.stryker-mutator.io/reports/github.com/VGirol/JsonApi-Faker/master
[link-contributors]: ../../contributors
