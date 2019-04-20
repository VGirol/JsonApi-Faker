<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\ExpectationFailedException;
use VGirol\JsonApiAssert\Members;
use VGirol\JsonApiAssert\Messages;

/**
 * Assertions relating to the overall structure of the document
 */
trait AssertStructure
{
    /**
     * Asserts that a json document has valid structure.
     *
     * @param array     $json
     * @param boolean   $strict     If true, unsafe characters are not allowed when checking members name.
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasValidStructure($json, bool $strict): void
    {
        static::assertHasValidTopLevelMembers($json);

        if (isset($json[Members::DATA])) {
            static::assertIsValidPrimaryData($json[Members::DATA], $strict);

            if (isset($json[Members::INCLUDED])) {
                static::assertIsValidIncludedCollection($json[Members::INCLUDED], $json[Members::DATA], $strict);
            }
        }

        if (isset($json[Members::ERRORS])) {
            static::assertIsValidErrorsObject($json[Members::ERRORS], $strict);
        }

        if (isset($json[Members::META])) {
            static::assertIsValidMetaObject($json[Members::META], $strict);
        }

        if (isset($json[Members::JSONAPI])) {
            static::assertIsValidJsonapiObject($json[Members::JSONAPI], $strict);
        }

        if (isset($json[Members::LINKS])) {
            static::assertIsValidTopLevelLinksMember($json[Members::LINKS], $strict);
        }
    }

    /**
     * Asserts that a json document has valid top-level structure.
     *
     * @param array $json
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasValidTopLevelMembers($json): void
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
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidTopLevelLinksMember($json, bool $strict): void
    {
        $allowed = ['self', 'related', 'first', 'last', 'next', 'prev'];
        static::assertIsValidLinksObject($json, $allowed, $strict);
    }

    /**
     * Asserts a json fragment is a valid primary data object.
     *
     * @param array     $json
     * @param boolean   $strict     If true, unsafe characters are not allowed when checking members name.
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidPrimaryData($json, bool $strict): void
    {
        try {
            PHPUnit::assertIsArray(
                $json,
                Messages::PRIMARY_DATA_NOT_ARRAY
            );
            if (empty($json)) {
                return;
            }
        } catch (ExpectationFailedException $e) {
            PHPUnit::assertNull(
                $json,
                Messages::PRIMARY_DATA_NOT_ARRAY
            );
            return;
        }

        if (static::isArrayOfObjects($json)) {
            // Resource collection (Resource Objects or Resource Identifier Objects)
            static::assertIsValidPrimaryCollection($json, true, $strict);

            return;
        }

        // Single Resource (Resource Object or Resource Identifier Object)
        static::assertIsValidPrimarySingle($json, $strict);
    }

    /**
     * Asserts that a collection of resource object is valid.
     *
     * @param array     $list
     * @param boolean   $checkType      If true, asserts that all resources of the collection are of same type.
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    private static function assertIsValidPrimaryCollection($list, bool $checkType, bool $strict): void
    {
        $isResourceObject = null;
        foreach ($list as $index => $resource) {
            if ($checkType) {
                // Assert that all resources of the collection are of same type.
                if ($index == 0) {
                    $isResourceObject = static::dataIsResourceObject($resource);
                    continue;
                }

                PHPUnit::assertEquals(
                    $isResourceObject,
                    static::dataIsResourceObject($resource),
                    Messages::PRIMARY_DATA_SAME_TYPE
                );
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
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    private static function assertIsValidPrimarySingle($resource, bool $strict): void
    {
        if (static::dataIsResourceObject($resource)) {
            static::assertIsValidResourceObject($resource, $strict);

            return;
        }

        static::assertIsValidResourceIdentifierObject($resource, $strict);
    }

    /**
     * Asserts that a collection of included resources is valid.
     *
     * @param array     $included   The included top-level member of the json document.
     * @param array     $data       The primary data of the json document.
     * @param boolean   $strict     If true, unsafe characters are not allowed when checking members name.
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidIncludedCollection($included, $data, bool $strict): void
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
