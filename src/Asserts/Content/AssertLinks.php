<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Asserts\Content;

use PHPUnit\Framework\Assert as PHPUnit;

/**
 * Assertions relating to the pagination
 */
trait AssertLinks
{
    /**
     * Asserts that a links object equals an expected links array.
     *
     * @param array $expected
     * @param array $links
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertLinksObjectEquals($expected, $links): void
    {
        PHPUnit::assertEquals(count($expected), count($links));
        foreach ($expected as $name => $value) {
            static::assertLinksObjectContains($name, $value, $links);
        }
    }

    /**
     * Asserts that a links object contains an expected link.
     *
     * @param string $name
     * @param array $expected
     * @param array $links
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertLinksObjectContains($name, $expected, $links): void
    {
        static::assertHasMember($name, $links);
        static::assertLinkObjectEquals($expected, $links[$name]);
    }

    /**
     * Asserts that a link object equals an expected value.
     *
     * @param array $expected
     * @param array $link
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertLinkObjectEquals($expected, $link): void
    {
        PHPUnit::assertSame($expected, $link);
    }
}
