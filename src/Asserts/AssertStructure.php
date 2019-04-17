<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\ExpectationFailedException;
use VGirol\JsonApiAssert\Messages;

trait AssertStructure
{
    /**
     * Asserts that a json document has valid structure.
     *
     * @param array     $json
     * @param boolean   $strict     If true, unsafe characters are not allowed when checking members name.
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasValidStructure($json, $strict)
    {
        static::assertHasValidTopLevelMembers($json);

        if (isset($json['data'])) {
            static::assertIsValidPrimaryData($json['data'], $strict);
        }

        if (isset($json['errors'])) {
            static::assertIsValidErrorsObject($json['errors'], $strict);
        }

        if (isset($json['meta'])) {
            static::assertIsValidMetaObject($json['meta'], $strict);
        }

        if (isset($json['jsonapi'])) {
            static::assertIsValidJsonapiObject($json['jsonapi'], $strict);
        }

        if (isset($json['links'])) {
            static::assertIsValidTopLevelLinksMember($json['links'], $strict);
        }

        if (isset($json['included'])) {
            static::assertIsValidIncludedCollection($json['included'], $json['data'], $strict);
        }
    }

    /**
     * Asserts that a json document has valid top-level structure.
     *
     * @param array $json
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasValidTopLevelMembers($json)
    {
        $expected = ['data', 'errors', 'meta'];
        static::assertContainsAtLeastOneMember(
            $expected,
            $json,
            \sprintf(Messages::TOP_LEVEL_MEMBERS, implode('", "', $expected))
        );

        PHPUnit::assertFalse(
            isset($json['data']) && isset($json['errors']),
            Messages::TOP_LEVEL_DATA_AND_ERROR
        );

        $allowed = ['data', 'errors', 'meta', 'jsonapi', 'links', 'included'];
        static::assertContainsOnlyAllowedMembers(
            $allowed,
            $json
        );

        PHPUnit::assertFALSE(
            !isset($json['data']) && isset($json['included']),
            Messages::TOP_LEVEL_DATA_AND_INCLUDED
        );
    }

    /**
     * Asserts that a json fragment is a valid top-level links member.
     *
     * @param array     $json
     * @param boolean   $strict     If true, unsafe characters are not allowed when checking members name.
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidTopLevelLinksMember($json, $strict)
    {
        $allowed = ['self', 'related', 'first', 'last', 'next', 'prev'];
        static::assertIsValidLinksObject($json, $allowed, $strict);
    }

    /**
     * Asserts a json fragment is a valid primary data object.
     *
     * @param array     $data
     * @param boolean   $strict     If true, unsafe characters are not allowed when checking members name.
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidPrimaryData($data, $strict)
    {
        try {
            PHPUnit::assertIsArray(
                $data,
                Messages::PRIMARY_DATA_NOT_ARRAY
            );
            if (empty($data)) {
                return;
            }
        } catch (ExpectationFailedException $e) {
            PHPUnit::assertNull(
                $data,
                Messages::PRIMARY_DATA_NOT_ARRAY
            );
            return;
        }

        if (static::isArrayOfObjects($data)) {
            // Resource collection (Resource Objects or Resource Identifier Objects)
            static::assertIsValidPrimaryCollection($data, true, $strict);
        } else {
            // Single Resource (Resource Object or Resource Identifier Object)
            static::assertIsValidPrimarySingle($data, $strict);
        }
    }

    /**
     * Asserts that a collection of resource object is valid.
     *
     * @param array     $list
     * @param boolean   $checkType      If true, asserts that all resources of the collection are of same type.
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    private static function assertIsValidPrimaryCollection($list, $checkType, $strict)
    {
        $isResourceObject = null;
        foreach ($list as $index => $resource) {
            if ($checkType) {
                // Assert that all resources of the collection are of same type.
                if ($index == 0) {
                    $isResourceObject = static::dataIsResourceObject($resource);
                } else {
                    PHPUnit::assertEquals(
                        $isResourceObject,
                        static::dataIsResourceObject($resource),
                        Messages::PRIMARY_DATA_SAME_TYPE
                    );
                }
            }

            // Check the resource
            static::assertIsValidPrimarySingle($resource, $strict);
        }
    }

    /**
     * Assert that a single resource object is valid.
     *
     * @param array     $resource
     * @param boolean   $strict     If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    private static function assertIsValidPrimarySingle($resource, $strict)
    {
        if (static::dataIsResourceObject($resource)) {
            static::assertIsValidResourceObject($resource, $strict);
        } else {
            static::assertIsValidResourceIdentifierObject($resource, $strict);
        }
    }

    /**
     * Asserts that a collection of included resources is valid.
     *
     * @param array     $included   The included top-level member of a json document.
     * @param array     $data       The primary data of a json document.
     * @param boolean   $strict     If true, unsafe characters are not allowed when checking members name.
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidIncludedCollection($included, $data, $strict)
    {
        static::assertIsArrayOfObjects($included);
        foreach ($included as $resource) {
            static::assertIsValidResourceObject($resource, $strict);
        }

        $resIdentifiers = array_merge(
            static::getAllResourceIdentifierObjects($data),
            static::getAllResourceIdentifierObjects($included)
        );

        $present = [];
        foreach ($included as $inc) {
            PHPUnit::assertTrue(
                self::existsInArray($inc, $resIdentifiers),
                Messages::INCLUDED_RESOURCE_NOT_LINKED
            );

            if (!isset($present[$inc['type']])) {
                $present[$inc['type']] = [];
            }
            PHPUnit::assertNotContains(
                $inc['id'],
                $present[$inc['type']],
                Messages::COMPOUND_DOCUMENT_ONLY_ONE_RESOURCE
            );
            array_push($present[$inc['type']], $inc['id']);
        }
    }

    private static function dataIsResourceObject($resource)
    {
        $expected = ['attributes', 'relationships', 'links'];

        return static::containsAtLeastOneMember($expected, $resource);
    }

    private static function getAllResourceIdentifierObjects($data)
    {
        $arr = [];
        if (empty($data)) {
            return $arr;
        }
        if (!static::isArrayOfObjects($data)) {
            $data = [$data];
        }
        foreach ($data as $obj) {
            if (!isset($obj['relationships'])) {
                continue;
            }
            foreach ($obj['relationships'] as $relationship) {
                if (!isset($relationship['data'])) {
                    continue;
                }
                $arr = array_merge(
                    $arr,
                    static::isArrayOfObjects($relationship['data']) ? $relationship['data'] : [$relationship['data']]
                );
            }
        }

        return $arr;
    }

    private static function existsInArray($needle, $arr)
    {
        foreach ($arr as $resIdentifier) {
            if (($resIdentifier['type'] === $needle['type']) && ($resIdentifier['id'] === $needle['id'])) {
                return true;
            }
        }

        return false;
    }
}
