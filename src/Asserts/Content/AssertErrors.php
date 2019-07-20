<?php

namespace VGirol\JsonApiAssert\Asserts\Content;

use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\ExpectationFailedException;
use VGirol\JsonApiAssert\Messages;

trait AssertErrors
{
    /**
     * Asserts that an errors array contains a given subset of expected errors.
     *
     * @param array $expectedErrors
     * @param array $errors
     * @param boolean $strict   If true, unsafe characters are not allowed when checking members name.
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertErrorsContains($expectedErrors, $errors, $strict)
    {
        try {
            static::assertIsValidErrorsObject($expectedErrors, $strict);
        } catch (ExpectationFailedException $e) {
            static::invalidArgument(1, 'errors object', $expectedErrors);
        }

        static::assertIsValidErrorsObject($errors, $strict);

        PHPUnit::assertGreaterThanOrEqual(
            count($expectedErrors),
            count($errors),
            Messages::ERRORS_OBJECT_CONTAINS_NOT_ENOUGH_ERRORS
        );

        foreach ($expectedErrors as $expectedError) {
            PHPUnit::assertContains($expectedError, $errors);
        }
    }
}
