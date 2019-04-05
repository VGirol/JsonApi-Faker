<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Messages;

trait AssertMemberName
{
    /**
     * Asserts that a member name is valid.
     *
     * @param string    $name
     * @param boolean   $strict
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidMemberName($name, $strict)
    {
        PHPUnit::assertIsString(
            $name,
            Messages::MEMBER_NAME_IS_NOT_STRING
        );

        PHPUnit::assertGreaterThanOrEqual(
            1,
            strlen($name),
            Messages::MEMBER_NAME_IS_TOO_SHORT
        );

        // Globally allowed characters
        $globally = '\x{0030}-\x{0039}\x{0041}-\x{005A}\x{0061}-\x{007A}';
        $globallyNotSafe = '\x{0080}-\x{FFFF}';
        // Allowed characters
        $allowed = '\x{002D}\x{005F}';
        $allowedNotSafe = '\x{0020}';

        $regex = $strict ? "/[^{$globally}{$allowed}]+/u" :
            "/[^{$globally}{$globallyNotSafe}{$allowed}{$allowedNotSafe}]+/u";

        PHPUnit::assertNotRegExp(
            $regex,
            $name,
            Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
        );

        $regex = $strict ? "/^[{$globally}]{1}(?:.*[{$globally}]{1})?$/u" :
            "/^[{$globally}{$globallyNotSafe}]{1}(?:.*[{$globally}{$globallyNotSafe}]{1})?$/u";
        PHPUnit::assertRegExp(
            $regex,
            $name,
            Messages::MEMBER_NAME_START_AND_END_WITH_ALLOWED_CHARACTERS
        );
    }
}
