<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Messages;
use PHPUnit\Framework\ExpectationFailedException;
use VGirol\JsonApiAssert\Constraint\ContainsAtLeastOneConstraint;
use VGirol\JsonApiAssert\Constraint\ContainsOnlyAllowedMembersConstraint;

trait AssertBase
{
    /**
     * Asserts that a json object has an expected member.
     *
     * @param array     $json
     * @param string    $key
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasMember($json, $key)
    {
        PHPUnit::assertArrayHasKey($key, $json, sprintf(Messages::HAS_MEMBER, $key));
    }

    /**
     * Asserts that a json object not has an unexpected member.
     *
     * @param array     $json
     * @param string    $key
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertNotHasMember($json, $key)
    {
        PHPUnit::assertArrayNotHasKey($key, $json, sprintf(Messages::NOT_HAS_MEMBER, $key));
    }

    /**
     * Asserts that a json object has a "data" member.
     *
     * @param array     $json
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasData($json)
    {
        static::assertHasMember($json, 'data');
    }

    /**
     * Asserts that a json object has an "attributes" member.
     *
     * @param array     $json
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasAttributes($json)
    {
        static::assertHasMember($json, 'attributes');
    }

    /**
     * Asserts that a json object has a "links" member.
     *
     * @param array     $json
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasLinks($json)
    {
        static::assertHasMember($json, 'links');
    }

    /**
     * Asserts that a json object has a "meta" member.
     *
     * @param array     $json
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasMeta($json)
    {
        static::assertHasMember($json, 'meta');
    }

    /**
     * Asserts that a json object has an "included" member.
     *
     * @param array     $json
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasIncluded($json)
    {
        static::assertHasMember($json, 'included');
    }

    /**
     * Asserts that a json object has a "relationships" member.
     *
     * @param array     $json
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasRelationships($json)
    {
        static::assertHasMember($json, 'relationships');
    }

    /**
     * Asserts that a json object has an "errors" member.
     *
     * @param array     $json
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasErrors($json)
    {
        static::assertHasMember($json, 'errors');
    }

    /**
     * Asserts that a json object contains at least one member from the list provided.
     *
     * @param array $expected   The expected members
     * @param array $json       The json object
     * @param string $message   An optional message to explain why the test failed
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertContainsAtLeastOneMember($expected, $json, $message = '')
    {
        PHPUnit::assertThat($json, self::containsAtLeastOneMemberConstraint($expected), $message);
    }

    /**
     * Returns a new instance of the VGirol\JsonApiAssert\Constraint\ContainsAtLeastOneConstraint class.
     *
     * @param array $expected   The expected members
     * 
     * @return VGirol\JsonApiAssert\Constraint\ContainsAtLeastOneConstraint
     */
    public static function containsAtLeastOneMemberConstraint($expected)
    {
        return new ContainsAtLeastOneConstraint($expected);
    }

    /**
     * Check if a json object contains at least one member from the list provided.
     *
     * @param array $expected   The expected members
     * @param array $json       The json object
     * 
     * @return boolean
     */
    public static function containsAtLeastOneMember($expected, $json)
    {
        $constraint = static::containsAtLeastOneMemberConstraint($expected);

        return $constraint->check($json);
    }

    /**
     * Asserts that a json object contains only members from the list provided.
     *
     * @param array $expected   The expected members
     * @param array $json       The json object
     * @param string $message   An optional message to explain why the test failed
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertContainsOnlyAllowedMembers($expected, $json, $message = '')
    {
        $message = Messages::ONLY_ALLOWED_MEMBERS . "\n" . $message;
        PHPUnit::assertThat($json, self::containsOnlyAllowedMembersConstraint($expected), $message);
    }

    /**
     * Returns a new instance of the VGirol\JsonApiAssert\Constraint\ContainsOnlyAllowedMembersConstraint class.
     *
     * @param array $expected   The expected members
     * 
     * @return VGirol\JsonApiAssert\Constraint\ContainsOnlyAllowedMembersConstraint
     */
    public static function containsOnlyAllowedMembersConstraint($expected)
    {
        return new ContainsOnlyAllowedMembersConstraint($expected);
    }

    /**
     * Asserts that an array is an array of objects.
     *
     * @param array     $data
     * @param string    $message   An optional message to explain why the test failed
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsArrayOfObjects($data, $message = '')
    {
        $message = $message ?: Messages::MUST_BE_ARRAY_OF_OBJECTS;
        PHPUnit::assertIsArray($data, $message);
        PHPUnit::assertTrue(static::isArrayOfObjects($data), $message);
    }

    /**
     * Asserts that an array is not an array of objects.
     *
     * @param array     $data
     * @param string    $message   An optional message to explain why the test failed
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsNotArrayOfObjects($data, $message = '')
    {
        $message = $message ?: Messages::MUST_NOT_BE_ARRAY_OF_OBJECTS;
        PHPUnit::assertIsArray($data, $message);
        PHPUnit::assertFalse(static::isArrayOfObjects($data), $message);
    }

    /**
     * Asserts that a test failed.
     *
     * @param Closure|callback $fn
     * @param string $expectedFailureMessage
     * @param mixed $args
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertTestFail($fn, $expectedFailureMessage)
    {
        $args = array_slice(func_get_args(), 2);

        try {
            call_user_func_array($fn, $args);
        } catch(ExpectationFailedException $e) {
            if (!is_null($expectedFailureMessage)) {
                PHPUnit::assertStringContainsString($expectedFailureMessage, $e->getMessage());
            }

            return;
        }

        throw new ExpectationFailedException(Messages::TEST_FAILED);
    }

    private static function isArrayOfObjects($arr)
    {
        if (!is_array($arr)) {
            return false;
        }
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
