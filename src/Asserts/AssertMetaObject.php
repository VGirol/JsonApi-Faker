<?php
namespace VGirol\JsonApiAssert\Asserts;

use VGirol\JsonApiAssert\Messages;

trait AssertMetaObject
{
    /**
     * Asserts that a json fragment is a valid meta object.
     *
     * @param array     $json
     * @param boolean   $strict         If true, unsafe characters are not allowed when checking members name.
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidMetaObject($json, $strict)
    {
        static::assertIsNotArrayOfObjects(
            $json,
            Messages::META_OBJECT_IS_NOT_ARRAY
        );

        foreach (array_keys($json) as $key) {
            static::assertIsValidMemberName($key, $strict);
        }
    }
}
