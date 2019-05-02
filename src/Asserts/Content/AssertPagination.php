<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Asserts\Content;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Members;

/**
 * Assertions relating to the pagination
 */
trait AssertPagination
{
    /**
     * Asserts that a links object has pagination links.
     *
     * @param array $links
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasPaginationLinks($links): void
    {
        $members = [
            Members::FIRST,
            Members::LAST,
            Members::PREV,
            Members::NEXT
        ];
        static::assertContainsAtLeastOneMember($members, $links);
    }

    /**
     * Asserts that a links object has no pagination links.
     *
     * @param array $links
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasNoPaginationLinks($links): void
    {
        $members = [
            Members::FIRST,
            Members::LAST,
            Members::PREV,
            Members::NEXT
        ];
        foreach ($members as $name) {
            static::assertNotHasMember($name, $links);
        }
    }

    /**
     * Asserts that a links object has the expected pagination links.
     *
     * @param array $expected
     * @param array $json
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertPaginationLinksEquals($expected, $json): void
    {
        foreach ($expected as $name => $expectedLink) {
            if ($expectedLink === false) {
                PHPUnit::assertNotHasMember($name, $json);
                continue;
            }
            static::assertHasMember($name, $json);

            if ($expectedLink === true) {
                continue;
            }

            static::assertLinksObjectContains($name, $expectedLink, $json);
        }
    }
}
