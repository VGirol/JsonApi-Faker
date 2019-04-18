<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Util\InvalidArgumentHelper;
use VGirol\JsonApiAssert\Messages;

trait AssertArrays
{
    /**
     * Asserts that an array is an array of objects.
     *
     * @param array     $json
     * @param string    $message   An optional message to explain why the test failed
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsArrayOfObjects($json, $message = '')
    {
        if (!\is_array($json)) {
            throw InvalidArgumentHelper::factory(
                1,
                'array',
                $json
            );
        }

        $message = $message ?: Messages::MUST_BE_ARRAY_OF_OBJECTS;
        PHPUnit::assertTrue(static::isArrayOfObjects($json), $message);
    }

    /**
     * Asserts that an array is not an array of objects.
     *
     * @param array     $json
     * @param string    $message   An optional message to explain why the test failed
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsNotArrayOfObjects($json, $message = '')
    {
        if (!\is_array($json)) {
            throw InvalidArgumentHelper::factory(
                1,
                'array',
                $json
            );
        }

        $message = $message ?: Messages::MUST_NOT_BE_ARRAY_OF_OBJECTS;
        PHPUnit::assertFalse(static::isArrayOfObjects($json), $message);
    }

    private static function isArrayOfObjects($arr)
    {
        if (empty($arr)) {
            return true;
        }

        return !static::arrayIsAssociative($arr);
    }

    private static function arrayIsAssociative($arr)
    {
        return (array_keys($arr) !== range(0, count($arr) - 1));
    }
}
