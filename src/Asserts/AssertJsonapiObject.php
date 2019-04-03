<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Messages;

trait AssertJsonapiObject
{
    /**
     * Asserts that a jsonapi object is valid.
     *
     * @param array     $jsonapi
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidJsonapiObject($jsonapi, $strict)
    {
        static::assertIsNotArrayOfObjects(
            $jsonapi,
            Messages::OBJECT_NOT_ARRAY
        );

        $allowed = ['version', 'meta'];
        static::assertContainsOnlyAllowedMembers(
            $allowed,
            $jsonapi
        );

        if (isset($jsonapi['version'])) {
            PHPUnit::assertIsString(
                $jsonapi['version'],
                Messages::JSONAPI_VERSION_IS_NOT_STRING
            );
        }

        if (isset($jsonapi['meta'])) {
            static::assertIsValidMetaObject($jsonapi['meta'], $strict);
        }
    }
}
