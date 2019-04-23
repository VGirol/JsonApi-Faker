<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Members;
use VGirol\JsonApiAssert\Messages;

/**
 * Assertions relating to the resource object
 */
trait AssertResourceObject
{
    /**
     * Asserts that a json fragment is a valid resource.
     *
     * @param array     $json
     * @param boolean   $strict         If true, unsafe characters are not allowed when checking members name.
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidResourceObject($json, bool $strict): void
    {
        static::assertResourceObjectHasValidTopLevelStructure($json);
        static::assertResourceIdMember($json);
        static::assertResourceTypeMember($json, $strict);

        if (isset($json[Members::ATTRIBUTES])) {
            static::assertIsValidAttributesObject($json[Members::ATTRIBUTES], $strict);
        }

        if (isset($json[Members::RELATIONSHIPS])) {
            static::assertIsValidRelationshipsObject($json[Members::RELATIONSHIPS], $strict);
        }

        if (isset($json[Members::LINKS])) {
            static::assertIsValidResourceLinksObject($json[Members::LINKS], $strict);
        }

        if (isset($json[Members::META])) {
            static::assertIsValidMetaObject($json[Members::META], $strict);
        }

        static::assertHasValidFields($json);
    }

    /**
     * Asserts that a resource object has a valid top-level structure.
     *
     * @param array $resource
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertResourceObjectHasValidTopLevelStructure($resource): void
    {
        PHPUnit::assertIsArray(
            $resource,
            Messages::RESOURCE_IS_NOT_ARRAY
        );

        PHPUnit::assertArrayHasKey(
            Members::ID,
            $resource,
            Messages::RESOURCE_ID_MEMBER_IS_ABSENT
        );

        PHPUnit::assertArrayHasKey(
            Members::TYPE,
            $resource,
            Messages::RESOURCE_TYPE_MEMBER_IS_ABSENT
        );

        static::assertContainsAtLeastOneMember(
            [
                Members::ATTRIBUTES,
                Members::RELATIONSHIPS,
                Members::LINKS,
                Members::META
            ],
            $resource
        );

        static::assertContainsOnlyAllowedMembers(
            [
                Members::ID,
                Members::TYPE,
                Members::META,
                Members::ATTRIBUTES,
                Members::LINKS,
                Members::RELATIONSHIPS
            ],
            $resource
        );
    }

    /**
     * Asserts that a resource id member is valid.
     *
     * @param array $resource
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertResourceIdMember($resource): void
    {
        PHPUnit::assertNotEmpty(
            $resource[Members::ID],
            Messages::RESOURCE_ID_MEMBER_IS_EMPTY
        );

        PHPUnit::assertIsString(
            $resource[Members::ID],
            Messages::RESOURCE_ID_MEMBER_IS_NOT_STRING
        );
    }

    /**
     * Asserts that a resource type member is valid.
     *
     * @param array     $resource
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertResourceTypeMember($resource, bool $strict): void
    {
        PHPUnit::assertNotEmpty(
            $resource[Members::TYPE],
            Messages::RESOURCE_TYPE_MEMBER_IS_EMPTY
        );

        PHPUnit::assertIsString(
            $resource[Members::TYPE],
            Messages::RESOURCE_TYPE_MEMBER_IS_NOT_STRING
        );

        static::assertIsValidMemberName(
            $resource[Members::TYPE],
            $strict
        );
    }

    /**
     * Asserts that a json fragment is a valid resource links object.
     *
     * @param array     $json
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidResourceLinksObject($json, bool $strict): void
    {
        static::assertIsValidLinksObject(
            $json,
            [
                Members::SELF
            ],
            $strict
        );
    }

    /**
     * Asserts that a resource object has valid fields (i.e., a resource object’s attributes and its relationships).
     *
     * @param array $resource
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasValidFields($resource): void
    {
        if (isset($resource[Members::ATTRIBUTES])) {
            foreach (array_keys($resource[Members::ATTRIBUTES]) as $name) {
                static::assertIsNotForbiddenResourceFieldName($name);
            }
        }

        if (isset($resource[Members::RELATIONSHIPS])) {
            foreach (array_keys($resource[Members::RELATIONSHIPS]) as $name) {
                static::assertIsNotForbiddenResourceFieldName($name);

                if (isset($resource[Members::ATTRIBUTES])) {
                    PHPUnit::assertArrayNotHasKey(
                        $name,
                        $resource[Members::ATTRIBUTES],
                        Messages::FIELDS_HAVE_SAME_NAME
                    );
                }
            }
        }
    }

    /**
     * Asserts that a resource field name is not a forbidden name (like "type" or "id").
     *
     * @param string $name
     * @return void
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsNotForbiddenResourceFieldName(string $name): void
    {
        PHPUnit::assertNotContains(
            $name,
            [
                Members::TYPE,
                Members::ID
            ],
            Messages::FIELDS_NAME_NOT_ALLOWED
        );
    }
}
