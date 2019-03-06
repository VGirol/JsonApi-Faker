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
    public static function assertIsValidResourceObject($resource)
    {
        static::assertResourceObjectHasValidTopLevelStructure($resource);
        static::assertResourceIdMember($resource);
        static::assertResourceTypeMember($resource);

        if (isset($resource['attributes'])) {
            static::assertIsValidAttributesObject($resource['attributes']);
        }

        if (isset($resource['relationships'])) {
            static::assertIsValidRelationshipsObject($resource['relationships']);
        }

        if (isset($resource['links'])) {
            static::assertIsValidResourceLinksObject($resource['links']);
        }

        if (isset($resource['meta'])) {
            static::assertIsValidMetaObject($resource['meta']);
        }

        static::assertValidFields($resource);
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
     * @param array $resource
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertResourceTypeMember($resource)
    {
        PHPUnit::assertNotEmpty(
            $resource['type'],
            Messages::RESOURCE_TYPE_MEMBER_IS_EMPTY
        );

        PHPUnit::assertIsString(
            $resource['type'],
            Messages::RESOURCE_TYPE_MEMBER_IS_NOT_STRING
        );

        static::assertIsValidMemberName($resource['type']);
    }

    /**
     * Asserts that a links object extracted from a resource is valid.
     *
     * @param array $data
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidResourceLinksObject($data)
    {
        $allowed = ['self'];
        static::assertIsValidLinksObject($data, $allowed);
    }

    /**
     * Asserts that a resource identifier object is valid.
     *
     * @param array $resource
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidResourceIdentifierObject($resource)
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
        static::assertResourceTypeMember($resource);

        $allowed = ['id', 'type', 'meta'];
        static::assertContainsOnlyAllowedMembers($allowed, $resource);

        if (isset($resource['meta'])) {
            static::assertIsValidMetaObject($resource['meta']);
        }
    }

    /**
     * Asserts that a resource object has valid fields.
     *
     * @param array $resource
     * 
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertValidFields($resource)
    {
        $bHasAttributes = false;
        if (isset($resource['attributes'])) {
            $bHasAttributes = true;
            foreach (array_keys($resource['attributes']) as $name) {
                static::assertIsNotForbiddenFieldName($name);
            }
        }

        if (isset($resource['relationships'])) {
            foreach (array_keys($resource['relationships']) as $name) {
                static::assertIsNotForbiddenFieldName($name);

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
    public static function assertIsNotForbiddenFieldName($name)
    {
        $forbidden = ['type', 'id'];
        PHPUnit::assertNotContains(
            $name,
            $forbidden,
            Messages::FIELDS_NAME_NOT_ALLOWED
        );
    }
}
