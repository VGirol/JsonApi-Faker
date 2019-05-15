<?php

namespace VGirol\JsonApiAssert\Asserts\Content;

use DMS\PHPUnitExtensions\ArraySubset\Constraint\ArraySubset;
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
            $test = false;
            $constraint = new ArraySubset($expectedError, true);
            foreach ($errors as $error) {
                $test = $test || $constraint->evaluate($error, '', true);
            }

            PHPUnit::assertTrue(
                $test,
                sprintf(
                    Messages::ERRORS_OBJECT_DOES_NOT_CONTAIN_EXPECTED_ERROR,
                    var_export($errors, true),
                    var_export($expectedError, true)
                )
            );
        }
    }
}
