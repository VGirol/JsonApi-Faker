# JsonApi-Assert

[![Build Status](https://travis-ci.org/VGirol/JsonApi-Assert.svg?branch=master)](https://travis-ci.org/VGirol/JsonApi-Assert)
[![Code Coverage](https://scrutinizer-ci.com/g/VGirol/JsonApi-Assert/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/VGirol/JsonApi-Assert/?branch=master)
[![Infection MSI](https://badge.stryker-mutator.io/github.com/VGirol/JsonApi-Assert/master)](https://infection.github.io)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/VGirol/JsonApi-Assert/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/VGirol/JsonApi-Assert/?branch=master)

This package provides a set of assertions to test documents using the [JSON:API specification](https://jsonapi.org/).

## Technologies

- PHP 7.2+
- PHPUnit 8.0+
  
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

You can use these assertions in your classes directly as a static call.

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
use VGirol\JsonApiAssert\Messages;
use VGirol\JsonApiAssert\Assert as JsonApiAssert;

class MyTest extends TestCase
{
    /**
     * @test
     */
    public function how_to_assert_that_a_test_failed()
    {
        $json = [
            'errors' => [
                'error' => 'not an array of error objects'
            ]
        ];
        $failureMsg = Messages::ERRORS_OBJECT_NOT_ARRAY;

        $fn = function ($json) {
            JsonApiAssert::assertHasValidStructure($json);
        };

        JsonApiAssert::assertTestFail($fn, $failureMsg, $json);
    }
}
```

## Assertions (`VGirol\JsonApiAssert\Assert`)

### assertContainsAtLeastOneMember

Asserts that a json object contains at least one member from the provided list.

Parameters :
- `$expected` (array)
- `$json` (array)
- `$message` (string)

### assertContainsOnlyAllowedMembers

Asserts that a json object contains only members from the provided list.

\$expected (array)  
\$json (array)  
\$message (string)


### assertFieldHasNoForbiddenMemberName

Asserts that a field object has no forbidden member name.

\$field (array)

It will do the following checks :
- asserts that each member name of the field is not a forbidden name ([assertIsNotForbiddenMemberName](#assertIsNotForbiddenMemberName)).
- if the field has nested objects, it will checks each all.


### assertHasAttributes

Asserts that a json object has an "attributes" member.

\$json (array)


### assertHasData

Asserts that a json object has a "data" member.

\$json (array)


### assertHasErrors

Asserts that a json object has an "errors" member.

\$json (array)


### assertHasIncluded

Asserts that a json object has an "included" member.

\$json (array)


### assertHasLinks

Asserts that a json object has a "links" member.

\$json (array)


### assertHasMember

Asserts that a json object has an expected member.

\$expected (string)  
\$json (array)


### assertHasMembers

Asserts that a json object has expected members.

\$expected (array)  
\$json (array)


### assertHasMeta

Asserts that a json object has a "meta" member.

\$json (array)


### assertHasOnlyMembers

Asserts that a json object has only expected members.

\$expected (string)  
\$json (array)


### assertHasRelationships

Asserts that a json object has a "relationships" member.

\$json (array)


### assertHasValidFields

Asserts that a resource object has valid fields.

\$resource (array)

It will do the following checks :
- asserts that each attributes member and each relationship name is valid ([assertIsNotForbiddenResourceFieldName](#assertIsNotForbiddenResourceFieldName)).


### assertHasValidStructure

Asserts that a json document has valid structure.

\$json (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- checks top-level members ([assertHasValidTopLevelMembers](#assertHasValidTopLevelMembers))

Optionaly, if presents, it will checks :
- primary data ([assertIsValidPrimaryData](#assertIsValidPrimaryData))
- errors object ([assertIsValidErrorsObject](#assertIsValidErrorsObject))
- meta object ([assertIsValidMetaObject](#assertIsValidMetaObject))
- jsonapi object ([assertIsValidJsonapiObject](#assertIsValidJsonapiObject))
- top-level links object ([assertIsValidTopLevelLinksMember](#assertIsValidTopLevelLinksMember))
- included object ([assertIsValidIncludedCollection](#assertIsValidIncludedCollection))


### assertHasValidTopLevelMembers

Asserts that a json document has valid top-level structure.

\$json (array)

It will do the following checks :
- asserts that the json document contains at least one of the following top-level members : "data", "meta" or "errors" ([assertContainsAtLeastOneMember](#assertContainsAtLeastOneMember)).
- asserts that the members "data" and "errors" does not coexist in the same document.
- asserts that the json document contains only the following members : "data", "errors", "meta", "jsonapi", "links", "included" ([assertContainsOnlyAllowedMembers](#assertContainsOnlyAllowedMembers)).
- if the json document does not contain a top-level "data" member, the "included" member must not be present either.


### assertIsArrayOfObjects

Asserts that an array is an array of objects.

\$data (array)  
\$message (string)


### assertIsNotArrayOfObjects

Asserts that an array is not an array of objects.

\$data (array)  
\$message (string)


### assertIsNotForbiddenMemberName

Asserts that a member name is not forbidden.

\$name (string)

It will do the following checks :
- asserts that the member name is not a forbidden name like "relationships" and "links".


### assertIsNotForbiddenResourceFieldName

\$name (string)

It will do the following checks :
- asserts that the field name is not a forbidden name like "type" and "id".


### assertIsValidAttributesObject

Asserts that a json fragment is a valid attributes object.

\$json (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that attributes object is not an array of objects ([assertIsNotArrayOfObjects](#assertIsNotArrayOfObjects)).
- asserts that attributes object has no member with forbidden name ([assertFieldHasNoForbiddenMemberName](#assertFieldHasNoForbiddenMemberName)).
-  asserts that each member name of the attributes object is valid ([assertIsValidMemberName](#assertIsValidMemberName)).


### assertIsValidErrorLinksObject

Asserts that a json fragment is a valid error links object.

\$json (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that le links object is valid ([assertIsValidLinksObject](#assertIsValidLinksObject) with only "about" member allowed).


### assertIsValidErrorObject

Asserts that a json fragment is a valid error object.

\$json (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the error object is not empty.
- asserts it contains only the following allowed members : "id", "links", "status", "code", "title", "details", "source", "meta" ([assertContainsOnlyAllowedMembers](#assertContainsOnlyAllowedMembers)).
- if present, asserts that the "status" member is a string.
- if present, asserts that the "code" member is a string.
- if present, asserts that the "title" member is a string.
- if present, asserts that the "details" member is a string.
- if present, asserts that the "source" member is valid([assertIsValidErrorSourceObject](#assertIsValidErrorSourceObject)).
- if present, asserts that the "links" member is valid([assertIsValidErrorLinksObject](#assertIsValidErrorLinksObject)).
- if present, asserts that the "meta" member is valid([assertIsValidMetaObject](#assertIsValidMetaObject)).


### assertIsValidErrorsObject

Asserts that a json fragment is a valid errors object.

\$json (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the errors object is an array of objects ([assertIsArrayOfObjects](#assertIsArrayOfObjects)).
- asserts that each error object of the collection is valid ([assertIsValidErrorObject](#assertIsValidErrorObject)).


### assertIsValidErrorSourceObject

Asserts that a json fragment is a valid error source object.

\$json (array)

It will do the following checks :
- if the "pointer" member is present, asserts it is a string stating with a "/" character.
- if the "parameter" member is present, asserts that it is a string.


### assertIsValidIncludedCollection

\$included (array)  
\$data (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that it is an array of objects ([assertIsArrayOfObjects](#assertIsArrayOfObjects)).
- asserts that each resource of the collection is valid ([assertIsValidResourceObject](#assertIsValidResourceObject)).
- asserts that each resource in the collection corresponds to an existing resource linkage present in either primary data, primary data relationships or another included resource.
- asserts that each resource in the collection is unique (i.e. each couple id-type is unique).


### assertIsValidJsonapiObject

Asserts that a json fragment is a valid jsonapi object.

\$json (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the jsonapi object is not an array of objects ([assertIsNotArrayOfObjects](#assertIsNotArrayOfObjects)).
- asserts that the jsonapi object contains only the following allowed members : "version" and "meta" ([assertContainsOnlyAllowedMembers](#assertContainsOnlyAllowedMembers)).
- if present, asserts that the version member is a string.
- if present, asserts that meta member is valid ([assertIsValidMetaObject](#assertIsValidMetaObject)).


### assertIsValidLinkObject

Asserts that a json fragment is a valid link object.

\$json (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the link object is a string, an array or the `null` value.
- in case it is an array :
  - asserts that it has the "href" member.
  - asserts that it contains only the following allowed members : "href" and "meta" ([assertContainsOnlyAllowedMembers](#assertContainsOnlyAllowedMembers)).
  - if present, asserts that the meta object is valid ([assertIsValidMetaObject](#assertIsValidMetaObject)).
 

### assertIsValidLinksObject

Asserts that a json fragment is a valid links object.

\$json (array)  
\$allowedMembers (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that it contains only allowed members ([assertContainsOnlyAllowedMembers](#assertContainsOnlyAllowedMembers)).
- asserts that each member of the links object is a valid link object ([assertIsValidLinkObject](#assertIsValidLinkObject)).


### assertIsValidMemberName

Asserts that a member name is valid.

\$name (string)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the name is a string with at least one character.
- asserts that the name has only allowed characters (see the list [here](https://jsonapi.org/format/#document-member-names-allowed-characters)).
- asserts that it starts and ends with a globally allowed character (see the list [here](https://jsonapi.org/format/#document-member-names-allowed-characters)).


### assertIsValidMetaObject

Asserts that a json fragment is a valid meta object.

\$json (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the meta object is not an array of objects ([assertIsNotArrayOfObjects](#assertIsNotArrayOfObjects)).
- asserts that each member of the meta object is valid ([assertIsValidMemberName](#assertIsValidMemberName)).


### assertIsValidPrimaryData

Asserts a json fragment is a valid primary data object.

\$json (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the primary data is either an object, an array of objects or the `null` value.
- if the primary data is not null, checks if it is a valid single resource or a valid resource collection ([assertIsValidResourceObject](#assertIsValidResourceObject) or [assertIsValidResourceIdentifierObject](#assertIsValidResourceIdentifierObject)).


### assertIsValidRelationshipLinksObject

Asserts that a json fragment is a valid link object extracted from a relationship object.

\$json (array)  
\$withPagination (boolean)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the links object is valid ([assertIsValidLinksObject](#assertIsValidLinksObject)) with the following allowed members : "self", "related" and eventually pagination links ("first", "last", "prev" and "next").


### assertIsValidRelationshipObject

Asserts that a json fragment is a valid relationship object.

\$json (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the relationship object contains at least one of the following member : "links", "data", "meta" ([assertContainsAtLeastOneMember](#assertContainsAtLeastOneMember)).
- if present, asserts that the data member is valid ([assertIsValidResourceLinkage](#assertIsValidResourceLinkage)).
- if present, asserts that the links member is valid ([assertIsValidRelationshipLinksObject](#assertIsValidRelationshipLinksObject)).
- if present, asserts that the meta object is valid ([assertIsValidMetaObject](#assertIsValidMetaObject)).


### assertIsValidRelationshipsObject

Asserts that a json fragment is a valid relationships object.

\$json (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the relationships object is not an array of objects ([assertIsNotArrayOfObjects](#assertIsNotArrayOfObjects)).
- asserts that each relationship of the collection has a valid name ([assertIsValidMemberName](#assertIsValidMemberName)) and is a valid relationship object ([assertIsValidRelationshipObject](#assertIsValidRelationshipObject)).


### assertIsValidResourceIdentifierObject

Asserts that a json fragment is a valid resource identifier object.

\$resource (object)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the resource as "id" ([assertResourceIdMember](#assertResourceIdMember)) and "type" ([assertResourceTypeMember](#assertResourceTypeMember)) members.
- asserts that it contains only the following allowed members : "id", "type" and "meta" ([assertContainsOnlyAllowedMembers](#assertContainsOnlyAllowedMembers)).
- if present, asserts that the meta object is valid ([assertIsValidMetaObject](#assertIsValidMetaObject)).


### assertIsValidResourceLinkage

Asserts that a json fragment is a valid resource linkage object.

\$data (mixed)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the provided resource linkage is either an object, an array of objects or the `null` value.
- asserts that the resource linkage or the collection of resource linkage is valid ([assertIsValidResourceIdentifierObject](#assertIsValidResourceIdentifierObject)).


### assertIsValidResourceLinksObject

Asserts that a json fragment is a valid resource links object.

\$json (mixed)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that le links object is valid ([assertIsValidLinksObject](#assertIsValidLinksObject) with only "self" member allowed).


### assertIsValidResourceObject

Asserts that a json fragment is a valid resource.

\$json (mixed)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the resource has valid top-level structure ([assertResourceObjectHasValidTopLevelStructure](#assertResourceObjectHasValidTopLevelStructure)).
- asserts that the "id" member is valid ([assertResourceIdMember](#assertResourceIdMember)).
- asserts that the "type" member is valid ([assertResourceTypeMember](#assertResourceTypeMember)).
- if presents, asserts that the "attributes" member is valid ([assertIsValidAttributesObject](#assertIsValidAttributesObject)).
- if presents, asserts that the "relationships" member is valid ([assertIsValidRelationshipsObject](#assertIsValidRelationshipsObject)).
- if presents, asserts that the "links" member is valid ([assertIsValidResourceLinksObject](#assertIsValidResourceLinksObject)).
- if presents, asserts that the "meta" member is valid ([assertIsValidMetaObject](#assertIsValidMetaObject)).
- asserts that the resource has valid fields ([assertHasValidFields](#assertHasValidFields)).


### assertIsValidTopLevelLinksMember

Asserts that a json fragment is a valid top-level links member.

\$json (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the top-level "links" member contains only the following allowed members : "self", "related", "first", "last", "next", "prev" ([assertIsValidLinksObject](#assertIsValidLinksObject)).


### assertNotHasMember

Asserts that a json object not has an unexpected member.

\$expected (string)  
\$json (array)


### assertNotHasMembers

Asserts that a json object not has unexpected members.

\$expected (string)  
\$json (array)


### assertResourceIdMember

Asserts that a resource id member is valid.

\$resource (array)

It will do the following checks :
- asserts that the "id" member is not empty.
- asserts that the "id" member is a string.


### assertResourceObjectHasValidTopLevelStructure

Asserts that a resource object has a valid top-level structure.

\$resource (aray)

It will do the following checks :
- asserts that the resource has an "id" member.
- asserts that the resource has a "type" member.
- asserts that the resource contains at least one of the following members : "attributes", "relationships", "links", "meta" ([assertContainsAtLeastOneMember](#assertContainsAtLeastOneMember)).
- asserts that the resource contains only the following allowed members : "id", "type", "meta", "attributes", "links", "relationships" ([assertContainsOnlyAllowedMembers](#assertContainsOnlyAllowedMembers)).


### assertResourceTypeMember

Asserts that a resource type member is valid.

\$resource (array)  
\$strict (boolean) : if true, unsafe characters are not allowed when checking members name.

It will do the following checks :
- asserts that the "type" member is not empty.
- asserts that the "type" member is a string.
- asserts that the "type" member has a valid value ([assertIsValidMemberName](#assertIsValidMemberName)).


### assertTestFail

Asserts that a test failed.

\$fn (Closure|callback)  
\$expectedFailureMessage (string)  
\$args ...


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```sh
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

[Vincent Girol](mailto:vincent@girol.fr)

## License

This project is licensed under the [MIT](https://choosealicense.com/licenses/mit/) License.
