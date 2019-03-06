<?php
namespace VGirol\JsonApiAssert\Asserts;

use VGirol\JsonApiAssert\Messages;

trait AssertAttributesObject
{
    /**
     * Asserts that an attributes object is valid.
     *
     * @param array $attributes
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidAttributesObject($attributes)
    {
        static::assertIsNotArrayOfObjects(
            $attributes,
            Messages::ATTRIBUTES_OBJECT_IS_NOT_ARRAY
        );

        static::assertFieldHasNoForbiddenMemberName($attributes);

        foreach ($attributes as $key => $value) {
            static::assertIsValidMemberName($key);
        }
    }
}
