<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\ExpectationFailedException;
use VGirol\JsonApiAssert\Messages;

/**
 * Assertions relating to the links object
 */
trait AssertLinksObject
{
    /**
     * Asserts that a json fragment is a valid links object.
     *
     * @param array         $json
     * @param array<string> $allowedMembers
     * @param boolean       $strict         If true, unsafe characters are not allowed when checking members name.
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidLinksObject($json, array $allowedMembers, bool $strict): void
    {
        PHPUnit::assertIsArray(
            $json,
            Messages::LINKS_OBJECT_NOT_ARRAY
        );

        static::assertContainsOnlyAllowedMembers(
            $allowedMembers,
            $json
        );

        foreach ($json as $link) {
            static::assertIsValidLinkObject($link, $strict);
        }
    }

    /**
     * Asserts that a json fragment is a valid link object.
     *
     * @param array     $json
     * @param boolean   $strict         If true, unsafe characters are not allowed when checking members name.
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidLinkObject($json, bool $strict): void
    {
        try {
            PHPUnit::assertIsArray($json);
        } catch (ExpectationFailedException $e) {
            try {
                PHPUnit::assertIsString($json);
                return;
            } catch (ExpectationFailedException $e) {
                PHPUnit::assertNull(
                    $json,
                    Messages::LINK_OBJECT_IS_NOT_ARRAY
                );
                return;
            }
        }

        PHPUnit::assertArrayHasKey(
            'href',
            $json,
            Messages::LINK_OBJECT_MISS_HREF_MEMBER
        );

        $allowed = ['href', 'meta'];
        static::assertContainsOnlyAllowedMembers(
            $allowed,
            $json
        );

        if (isset($json['meta'])) {
            static::assertIsValidMetaObject($json['meta'], $strict);
        }
    }
}
