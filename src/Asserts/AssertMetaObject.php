<?php
namespace VGirol\JsonApiAssert\Asserts;

use VGirol\JsonApiAssert\Messages;

trait AssertMetaObject
{
    /**
     * Asserts that a meta object is valid.
     *
     * @param array     $meta
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidMetaObject($meta, $strict)
    {
        static::assertIsNotArrayOfObjects(
            $meta,
            Messages::META_OBJECT_IS_NOT_ARRAY
        );

        foreach (array_keys($meta) as $key) {
            static::assertIsValidMemberName($key, $strict);
        }
    }
}
