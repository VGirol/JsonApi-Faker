# JsonApi-Faker

[![Build Status](https://travis-ci.org/VGirol/JsonApi-Faker.svg?branch=master)](https://travis-ci.org/VGirol/JsonApi-Faker)
[![Code Coverage](https://scrutinizer-ci.com/g/VGirol/JsonApi-Faker/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/VGirol/JsonApi-Faker/?branch=master)
[![Infection MSI](https://badge.stryker-mutator.io/github.com/VGirol/JsonApi-Faker/master)](https://infection.github.io)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/VGirol/JsonApi-Faker/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/VGirol/JsonApi-Faker/?branch=master)

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

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```sh
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

[Vincent Girol](mailto:vincent@girol.fr)

## License

This project is licensed under the [MIT](https://choosealicense.com/licenses/mit/) License.
