<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Messages;
use PHPUnit\Framework\ExpectationFailedException;

trait AssertRelationshipsObject
{
    /**
     * Asserts that a relationships object is valid.
     *
     * @param array     $relationships
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidRelationshipsObject($relationships, $strict)
    {
        static::assertIsNotArrayOfObjects($relationships);

        foreach ($relationships as $key => $relationship) {
            static::assertIsValidMemberName($key, $strict);
            static::assertIsValidRelationshipObject($relationship, $strict);
        }
    }

    /**
     * Asserts that a relationship object is valid.
     *
     * @param array     $relationship
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidRelationshipObject($relationship, $strict)
    {
        $expected = ['links', 'data', 'meta'];
        static::assertContainsAtLeastOneMember($expected, $relationship);

        if (isset($relationship['data'])) {
            $data = $relationship['data'];
            static::assertIsValidResourceLinkage($data, $strict);
        }

        if (isset($relationship['links'])) {
            $links = $relationship['links'];
            $withPagination = isset($relationship['data']) && static::isArrayOfObjects($relationship['data']);
            static::assertIsValidRelationshipLinksObject($links, $withPagination, $strict);
        }

        if (isset($relationship['meta'])) {
            static::assertIsValidMetaObject($relationship['meta'], $strict);
        }
    }

    /**
     * Asserts that a link object extracted from a relationship object is valid.
     *
     * @param array     $data
     * @param boolean   $withPagination
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidRelationshipLinksObject($data, $withPagination, $strict)
    {
        $allowed = ['self', 'related'];
        if ($withPagination) {
            $allowed = array_merge($allowed, ['first', 'last', 'next', 'prev']);
        }
        static::assertIsValidLinksObject($data, $allowed, $strict);
    }

    /**
     * Asserts that a resource linkage object is valid.
     *
     * @param array     $data
     * @param boolean   $strict     If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidResourceLinkage($data, $strict)
    {
        try {
            PHPUnit::assertIsArray(
                $data,
                Messages::RESOURCE_LINKAGE_NOT_ARRAY
            );
            if (empty($data)) {
                return;
            }
        } catch (ExpectationFailedException $e) {
            PHPUnit::assertNull(
                $data,
                Messages::RESOURCE_LINKAGE_NOT_ARRAY
            );
            return;
        }

        if (static::isArrayOfObjects($data)) {
            foreach ($data as $resource) {
                static::assertIsValidResourceIdentifierObject($resource, $strict);
            }
        } else {
            static::assertIsValidResourceIdentifierObject($data, $strict);
        }
    }
}
