<?php

namespace VGirol\JsonApiAssert\Asserts\Content;

use DMS\PHPUnitExtensions\ArraySubset\Constraint\ArraySubset;
use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\ExpectationFailedException;

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
            'Errors array must be greater or equal than the expected errors array.'
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
                    'Failed asserting that "errors" member %s contains the expected error %s.',
                    var_export($errors, true),
                    var_export($expectedError, true)
                )
            );
        }
    }
}