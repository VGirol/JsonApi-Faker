<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\ExpectationFailedException;
use VGirol\JsonApiAssert\Messages;

trait AssertResourceLinkage
{
    /**
     * Asserts that a json fragment is a valid resource linkage object.
     *
     * @param array     $json
     * @param boolean   $strict     If true, unsafe characters are not allowed when checking members name.
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidResourceLinkage($json, $strict)
    {
        try {
            PHPUnit::assertIsArray(
                $json,
                Messages::RESOURCE_LINKAGE_NOT_ARRAY
            );
            if (empty($json)) {
                return;
            }
        } catch (ExpectationFailedException $e) {
            PHPUnit::assertNull(
                $json,
                Messages::RESOURCE_LINKAGE_NOT_ARRAY
            );
            return;
        }

        if (!static::isArrayOfObjects($json)) {
            $json = [$json];
        }
        foreach ($json as $resource) {
            static::assertIsValidResourceIdentifierObject($resource, $strict);
        }
    }

    /**
     * Asserts that a json fragment is a valid resource identifier object.
     *
     * @param array     $resource
     * @param boolean   $strict         If true, unsafe characters are not allowed when checking members name.
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
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
}
