<?php

declare(strict_types=1);

namespace VGirol\JsonApiAssert\Asserts\Content;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Constraint\PaginationLinksEqualConstraint;
use VGirol\JsonApiAssert\Members;

/**
 * Assertions relating to the pagination
 */
trait AssertPagination
{
    /**
     * Gets the list of allowed members for pagination links
     *
     * @return array
     */
    private static function allowedMembers(): array
    {
        return [
            Members::FIRST,
            Members::LAST,
            Members::PREV,
            Members::NEXT
        ];
    }

    /**
     * Asserts that a links object has pagination links.
     *
     * @param array $links
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasPaginationLinks($links): void
    {
        static::assertContainsAtLeastOneMember(
            static::allowedMembers(),
            $links
        );
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
        foreach (static::allowedMembers() as $name) {
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
        PHPUnit::assertThat($json, self::paginationLinksEqualConstraint($expected));
    }

    /**
     * Returns a new instance of the \VGirol\JsonApiAssert\Constraint\PaginationLinksEqualConstraint class.
     *
     * @param array $expected   The expected links
     *
     * @return \VGirol\JsonApiAssert\Constraint\PaginationLinksEqualConstraint
     */
    private static function paginationLinksEqualConstraint($expected): PaginationLinksEqualConstraint
    {
        return new PaginationLinksEqualConstraint($expected);
    }
}
