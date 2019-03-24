<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Messages;
use PHPUnit\Framework\ExpectationFailedException;

trait AssertStructure
{
    /**
     * Asserts that a json document has valid structure.
     *
     * @param array $json
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasValidStructure($json)
    {
        static::assertHasValidTopLevelMembers($json);

        if (isset($json['data'])) {
            static::assertIsValidPrimaryData($json['data']);
        }

        if (isset($json['errors'])) {
            static::assertIsValidErrorsObject($json['errors']);
        }

        if (isset($json['meta'])) {
            static::assertIsValidMetaObject($json['meta']);
        }

        if (isset($json['jsonapi'])) {
            static::assertIsValidJsonapiObject($json['jsonapi']);
        }

        if (isset($json['links'])) {
            static::assertIsValidTopLevelLinksMember($json['links']);
        }

        if (isset($json['included'])) {
            static::assertIsValidIncludedCollection($json['included'], $json['data']);
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
     * Asserts that top-level links member of a json document is valid.
     *
     * @param array $links
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidTopLevelLinksMember($links)
    {
        $allowed = ['self', 'related', 'first', 'last', 'next', 'prev'];
        static::assertIsValidLinksObject($links, $allowed);
    }

    /**
     * Asserts that the primary data of a json document is valid.
     *
     * @param array] $data
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidPrimaryData($data)
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
            static::assertIsValidResourceCollection($data, true);
        } else {
            // Single Resource (Resource Object or Resource Identifier Object)
            static::assertIsValidSingleResource($data);
        }
    }

    /**
     * Asserts that a collection of resource object is valid.
     *
     * @param array     $list
     * @param boolean   $checkType  If true, asserts that all resources of the collection are of same type.
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidResourceCollection($list, $checkType)
    {
        static::assertIsArrayOfObjects($list);

        $isResourceObjectCollection = null;
        foreach ($list as $index => $resource) {
            if ($checkType) {
                // Assert that all resources of the collection are of same type.
                if ($index == 0) {
                    $isResourceObjectCollection = static::dataIsResourceObject($resource);
                } else {
                    PHPUnit::assertEquals(
                        $isResourceObjectCollection,
                        static::dataIsResourceObject($resource),
                        Messages::PRIMARY_DATA_SAME_TYPE
                    );
                }
            }

            // Check the resource
            static::assertIsValidSingleResource($resource);
        }
    }

    /**
     * Assert that a single resource object is valid.
     *
     * @param array $resource
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidSingleResource($resource)
    {
        static::assertIsNotArrayOfObjects($resource);

        if (static::dataIsResourceObject($resource)) {
            static::assertIsValidResourceObject($resource);
        } else {
            static::assertIsValidResourceIdentifierObject($resource);
        }
    }

    /**
     * Asserts that a collection of included resources is valid.
     *
     * @param array $included   The included top-level member of a json document.
     * @param array $data       The primary data of a json document.
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidIncludedCollection($included, $data)
    {
        static::assertIsArrayOfObjects($included);

        static::assertIsValidResourceCollection($included, false);

        $resIdentifiers = array_merge(
            static::getAllResourceIdentifierObjects($data),
            static::getAllResourceIdentifierObjects($included)
        );

        $present = [];
        foreach ($included as $inc) {
            PHPUnit::assertTrue(self::existsInArray($inc, $resIdentifiers));

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
            foreach ($obj['relationships'] as $key => $relationship) {
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
