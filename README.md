# JsonApi-Assert

Provides a number of assertions to test documents using the JSON:API specification.

## Technologies

- PHP 7
- PHPUnit 7
  
## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require-dev": {
        "vgirol/jsonapi-assert": "dev-master"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplified by using the following command:

```sh
composer require vgirol/jsonapi-assert
```

## Usage

```php
use PHPUnit\Framework\TestCase;
use VGirol\JsonApiAssert\Assert as JsonApiAssert;

class MyTest extends TestCase
{
    /**
     * @test
     */
    public function my_first_test()
    {
        $json = [
            'meta' => [
                'key' => 'value'
            ],
            'jsonapi' => [
                'version' => '1.0'
            ]
        ];

        JsonApiAssert::assertHasValidStructure($json);
    }
}
```

```php
use PHPUnit\Framework\TestCase;
use VGirol\JsonApiAssert\Assert as JsonApiAssert;

class MyTest extends TestCase
{
    /**
     * @test
     */
    public function my_first_test_that_failed()
    {
        $json = [
            'meta' => [
                'key' => 'value'
            ],
            'bad-member' => [
                'error' => 'not valid'
            ]
        ];

        $fn = function ($json) {
            JsonApiAssert::assertHasValidStructure($json);
        };

        JsonApiAssert::assertTestFail($fn, $failureMsg, $json);
    }
}
```

## Documentation

`VGirol\JsonApiAssert\Assert`

- assertContainsAtLeastOneMember($expected, $actual, $message = '')
- assertContainsOnlyAllowedMembers($expected, $actual, $message = '')
- assertFieldHasNoForbiddenMemberName($field)
- assertHasAttributes($json)
- assertHasData($json)
- assertHasErrors($json)
- assertHasIncluded($json)
- assertHasLinks($json)
- assertHasMember($json, $key)
- assertHasMeta($json)
- assertHasRelationships($json)
- assertHasValidStructure($json)
- assertHasValidTopLevelMembers($json)
- assertIsArrayOfObjects($data, $message = '')
- assertIsNotArrayOfObjects($data, $message = '')
- assertIsNotForbiddenFieldName($name)
- assertIsNotForbiddenMemberName($name)
- assertIsValidAttributesObject($attributes)
- assertIsValidErrorLinksObject($links)
- assertIsValidErrorObject($error)
- assertIsValidErrorsObject($errors)
- assertIsValidErrorSourceObject($source)
- assertIsValidIncludedCollection($included, $data)
- assertIsValidJsonapiObject($jsonapi)
- assertIsValidLinkObject($link)
- assertIsValidLinksObject($links, $allowedMembers)
- assertIsValidMemberName($name, $strict = false)
- assertIsValidMetaObject($meta)
- assertIsValidPrimaryData($data)
- assertIsValidRelationshipLinksObject($data, $withPagination)
- assertIsValidRelationshipObject($relationship)
- assertIsValidRelationshipsObject($relationships)
- assertIsValidResourceCollection($list, $checkType)
- assertIsValidResourceIdentifierObject($resource)
- assertIsValidResourceLinkage($data)
- assertIsValidResourceLinksObject($data)
- assertIsValidResourceObject($resource)
- assertIsValidSingleResource($resource)
- assertIsValidTopLevelLinksMember($links)
- assertNotHasMember($json, $key)
- assertResourceIdMember($resource)
- assertResourceObjectHasValidTopLevelStructure($resource)
- assertResourceTypeMember($resource)
- assertTestFail($fn, $expectedFailureMessage)
- assertValidFields($resource)

## Authors

[Vincent Girol](vincent@girol.fr)

## Contributing

## License

This project is licensed under the [MIT](https://choosealicense.com/licenses/mit/) License.