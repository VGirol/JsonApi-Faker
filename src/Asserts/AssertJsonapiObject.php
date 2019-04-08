<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Messages;

trait AssertJsonapiObject
{
    /**
     * Asserts that a json fragment is a valid jsonapi object.
     *
     * @param array     $json
     * @param boolean   $strict         If true, unsafe characters are not allowed when checking members name.
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidJsonapiObject($json, $strict)
    {
        static::assertIsNotArrayOfObjects(
            $json,
            Messages::OBJECT_NOT_ARRAY
        );

        $allowed = ['version', 'meta'];
        static::assertContainsOnlyAllowedMembers(
            $allowed,
            $json
        );

        if (isset($json['version'])) {
            PHPUnit::assertIsString(
                $json['version'],
                Messages::JSONAPI_VERSION_IS_NOT_STRING
            );
        }

        if (isset($json['meta'])) {
            static::assertIsValidMetaObject($json['meta'], $strict);
        }
    }
}
