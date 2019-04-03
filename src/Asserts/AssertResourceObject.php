<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Messages;

trait AssertResourceObject
{
    /**
     * Asserts that a resource has valid structure.
     *
     * @param array $resource
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidResourceObject($resource, $strict)
    {
        static::assertResourceObjectHasValidTopLevelStructure($resource);
        static::assertResourceIdMember($resource);
        static::assertResourceTypeMember($resource, $strict);

        if (isset($resource['attributes'])) {
            static::assertIsValidAttributesObject($resource['attributes'], $strict);
        }

        if (isset($resource['relationships'])) {
            static::assertIsValidRelationshipsObject($resource['relationships'], $strict);
        }

        if (isset($resource['links'])) {
            static::assertIsValidResourceLinksObject($resource['links'], $strict);
        }

        if (isset($resource['meta'])) {
            static::assertIsValidMetaObject($resource['meta'], $strict);
        }

        static::assertHasValidFields($resource);
    }

    /**
     * Asserts that a resource object has a valid top-level structure.
     *
     * @param array $resource
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
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
     * Asserts that a resource has a valid id member.
     *
     * @param array $resource
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
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
     * Asserts that a resource has a valid type member.
     *
     * @param array     $resource
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
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
     * Asserts that a links object extracted from a resource is valid.
     *
     * @param array     $data
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidResourceLinksObject($data, $strict)
    {
        $allowed = ['self'];
        static::assertIsValidLinksObject($data, $allowed, $strict);
    }

    /**
     * Asserts that a resource identifier object is valid.
     *
     * @param array     $resource
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidResourceIdentifierObject($resource, $strict)
    {
        PHPUnit::assertIsArray(
            $resource,
            Messages::RESOURCE_IDENTIFIER_IS_NOT_ARRAY
        );

        PHPUnit::assertArrayHasKey(
            'id',
            $resource,
            Messages::RESOURCE_ID_MEMBER_IS_ABSENT
        );
        static::assertResourceIdMember($resource);

        PHPUnit::assertArrayHasKey(
            'type',
            $resource,
            Messages::RESOURCE_TYPE_MEMBER_IS_ABSENT
        );
        static::assertResourceTypeMember($resource, $strict);

        $allowed = ['id', 'type', 'meta'];
        static::assertContainsOnlyAllowedMembers($allowed, $resource);

        if (isset($resource['meta'])) {
            static::assertIsValidMetaObject($resource['meta'], $strict);
        }
    }

    /**
     * Asserts that a resource object has valid fields.
     *
     * @param array $resource
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertHasValidFields($resource)
    {
        $bHasAttributes = false;
        if (isset($resource['attributes'])) {
            $bHasAttributes = true;
            foreach (array_keys($resource['attributes']) as $name) {
                static::assertIsNotForbiddenResourceFieldName($name);
            }
        }

        if (isset($resource['relationships'])) {
            foreach (array_keys($resource['relationships']) as $name) {
                static::assertIsNotForbiddenResourceFieldName($name);

                if ($bHasAttributes) {
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
     * @throws PHPUnit\Framework\ExpectationFailedException
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
