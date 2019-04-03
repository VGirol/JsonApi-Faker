<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Util\InvalidArgumentHelper;
use VGirol\JsonApiAssert\Messages;

trait AssertAttributesObject
{
    /**
     * Asserts that an attributes object is valid.
     *
     * @param array     $attributes
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidAttributesObject($attributes, $strict)
    {
        static::assertIsNotArrayOfObjects(
            $attributes,
            Messages::ATTRIBUTES_OBJECT_IS_NOT_ARRAY
        );

        static::assertFieldHasNoForbiddenMemberName($attributes);

        foreach (array_keys($attributes) as $key) {
            static::assertIsValidMemberName($key, $strict);
        }
    }

    /**
     * Asserts that a field object has no forbidden member name
     *
     * @param mixed $field
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertFieldHasNoForbiddenMemberName($field)
    {
        if (!is_array($field)) {
            return;
        }

        foreach ($field as $key => $value) {
            // For objects, $key is a string
            // For arrays of objects, $key is an integer
            if (is_string($key)) {
                static::assertIsNotForbiddenMemberName($key);
            }
            static::assertFieldHasNoForbiddenMemberName($value);
        }
    }

    /**
     * Asserts that a member name is not forbidden
     *
     * @param string $name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsNotForbiddenMemberName($name)
    {
        if (!\is_string($name)) {
            throw InvalidArgumentHelper::factory(
                1,
                'string',
                $name
            );
        }

        $forbidden = ['relationships', 'links'];
        PHPUnit::assertNotContains(
            $name,
            $forbidden,
            Messages::MEMBER_NAME_NOT_ALLOWED
        );
    }
}
