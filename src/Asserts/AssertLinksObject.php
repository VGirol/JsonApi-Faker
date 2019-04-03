<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Messages;
use PHPUnit\Framework\ExpectationFailedException;

trait AssertLinksObject
{
    /**
     * Asserts that a links object is valid.
     *
     * @param array     $links
     * @param array     $allowedMembers
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidLinksObject($links, $allowedMembers, $strict)
    {
        PHPUnit::assertIsArray(
            $links,
            Messages::LINKS_OBJECT_NOT_ARRAY
        );

        static::assertContainsOnlyAllowedMembers(
            $allowedMembers,
            $links
        );

        foreach ($links as $key => $link) {
            static::assertIsValidLinkObject($link, $strict);
        }
    }

    /**
     * Asserts that a link object is valid.
     *
     * @param array     $link
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidLinkObject($link, $strict)
    {
        try {
            PHPUnit::assertIsArray($link);
        } catch (ExpectationFailedException $e) {
            try {
                PHPUnit::assertIsString($link);
                return;
            } catch (ExpectationFailedException $e) {
                PHPUnit::assertNull(
                    $link,
                    Messages::LINK_OBJECT_IS_NOT_ARRAY
                );
                return;
            }
        }

        PHPUnit::assertArrayHasKey(
            'href',
            $link,
            Messages::LINK_OBJECT_MISS_HREF_MEMBER
        );

        $allowed = ['href', 'meta'];
        static::assertContainsOnlyAllowedMembers(
            $allowed,
            $link
        );

        if (isset($link['meta'])) {
            static::assertIsValidMetaObject($link['meta'], $strict);
        }
    }
}
