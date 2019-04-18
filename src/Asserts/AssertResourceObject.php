<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Messages;

trait AssertResourceObject
{
    /**
     * Asserts that a json fragment is a valid resource.
     *
     * @param array     $json
     * @param boolean   $strict         If true, unsafe characters are not allowed when checking members name.
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidResourceObject($json, $strict)
    {
        static::assertResourceObjectHasValidTopLevelStructure($json);
        static::assertResourceIdMember($json);
        static::assertResourceTypeMember($json, $strict);

        if (isset($json['attributes'])) {
            static::assertIsValidAttributesObject($json['attributes'], $strict);
        }

        if (isset($json['relationships'])) {
            static::assertIsValidRelationshipsObject($json['relationships'], $strict);
        }

        if (isset($json['links'])) {
            static::assertIsValidResourceLinksObject($json['links'], $strict);
        }

        if (isset($json['meta'])) {
            static::assertIsValidMetaObject($json['meta'], $strict);
        }

        static::assertHasValidFields($json);
    }

    /**
     * Asserts that a resource object has a valid top-level structure.
     *
     * @param array $resource
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertResourceObjectHasValidTopLevelStructure($resource)
    {
        PHPUnit::assertIsArray(
            $resource,
            Messages::RESOURCE_IS_NOT_ARRAY
        );

        PHPUnit::assertArrayHasKey(
            'id',
            $resource,
            Messages::RESOURCE_ID_MEMBER_IS_ABSENT
        );

        PHPUnit::assertArrayHasKey(
            'type',
            $resource,
            Messages::RESOURCE_TYPE_MEMBER_IS_ABSENT
        );

        static::assertContainsAtLeastOneMember(['attributes', 'relationships', 'links', 'meta'], $resource);

        $allowed = ['id', 'type', 'meta', 'attributes', 'links', 'relationships'];
        static::assertContainsOnlyAllowedMembers($allowed, $resource);
    }

    /**
     * Asserts that a resource id member is valid.
     *
     * @param array $resource
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertResourceIdMember($resource)
    {
        PHPUnit::assertNotEmpty(
            $resource['id'],
            Messages::RESOURCE_ID_MEMBER_IS_EMPTY
        );

        PHPUnit::assertIsString(
            $resource['id'],
            Messages::RESOURCE_ID_MEMBER_IS_NOT_STRING
        );
    }

    /**
     * Asserts that a resource type member is valid.
     *
     * @param array     $resource
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertResourceTypeMember($resource, $strict)
    {
        PHPUnit::assertNotEmpty(
            $resource['type'],
            Messages::RESOURCE_TYPE_MEMBER_IS_EMPTY
        );

        PHPUnit::assertIsString(
            $resource['type'],
            Messages::RESOURCE_TYPE_MEMBER_IS_NOT_STRING
        );

        static::assertIsValidMemberName($resource['type'], $strict);
    }

    /**
     * Asserts that a json fragment is a valid resource links object.
     *
     * @param array     $json
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidResourceLinksObject($json, $strict)
    {
        $allowed = ['self'];
        static::assertIsValidLinksObject($json, $allowed, $strict);
    }

    /**
     * Asserts that a resource object has valid fields.
     *
     * @param array $resource
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasValidFields($resource)
    {
        if (isset($resource['attributes'])) {
            foreach (array_keys($resource['attributes']) as $name) {
                static::assertIsNotForbiddenResourceFieldName($name);
            }
        }

        if (isset($resource['relationships'])) {
            foreach (array_keys($resource['relationships']) as $name) {
                static::assertIsNotForbiddenResourceFieldName($name);

                if (isset($resource['attributes'])) {
                    PHPUnit::assertArrayNotHasKey(
                        $name,
                        $resource['attributes'],
                        Messages::FIELDS_HAVE_SAME_NAME
                    );
                }
            }
        }
    }

    /**
     * Asserts that a field name is not forbidden.
     *
     * @param string $name
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsNotForbiddenResourceFieldName($name)
    {
        $forbidden = ['type', 'id'];
        PHPUnit::assertNotContains(
            $name,
            $forbidden,
            Messages::FIELDS_NAME_NOT_ALLOWED
        );
    }
}
