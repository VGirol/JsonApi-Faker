<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Messages;

trait AssertErrorsObject
{
    /**
     * Asserts that a json fragment is a valid errors object.
     *
     * @param array     $json
     * @param boolean   $strict         If true, unsafe characters are not allowed when checking members name.
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidErrorsObject($json, $strict)
    {
        static::assertIsArrayOfObjects(
            $json,
            Messages::ERRORS_OBJECT_NOT_ARRAY
        );

        foreach ($json as $error) {
            static::assertIsValidErrorObject($error, $strict);
        }
    }

    /**
     * Asserts that a json fragment is a valid error object.
     *
     * @param array     $json
     * @param boolean   $strict         If true, unsafe characters are not allowed when checking members name.
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidErrorObject($json, $strict)
    {
        PHPUnit::assertIsArray(
            $json,
            Messages::ERROR_OBJECT_NOT_ARRAY
        );

        PHPUnit::assertNotEmpty(
            $json,
            Messages::ERROR_OBJECT_NOT_EMPTY
        );

        $allowed = ['id', 'links', 'status', 'code', 'title', 'details', 'source', 'meta'];
        static::assertContainsOnlyAllowedMembers(
            $allowed,
            $json
        );

        if (isset($json['status'])) {
            PHPUnit::assertIsString(
                $json['status'],
                Messages::ERROR_STATUS_IS_NOT_STRING
            );
        }

        if (isset($json['code'])) {
            PHPUnit::assertIsString(
                $json['code'],
                Messages::ERROR_CODE_IS_NOT_STRING
            );
        }

        if (isset($json['title'])) {
            PHPUnit::assertIsString(
                $json['title'],
                Messages::ERROR_TITLE_IS_NOT_STRING
            );
        }

        if (isset($json['details'])) {
            PHPUnit::assertIsString(
                $json['details'],
                Messages::ERROR_DETAILS_IS_NOT_STRING
            );
        }

        if (isset($json['source'])) {
            static::assertIsValidErrorSourceObject($json['source']);
        }

        if (isset($json['links'])) {
            static::assertIsValidErrorLinksObject($json['links'], $strict);
        }

        if (isset($json['meta'])) {
            static::assertIsValidMetaObject($json['meta'], $strict);
        }
    }

    /**
     * Asserts that a json fragment is a valid error links object.
     *
     * @param array     $json
     * @param boolean   $strict         If true, unsafe characters are not allowed when checking members name.
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidErrorLinksObject($json, $strict)
    {
        $allowed = ['about'];
        static::assertIsValidLinksObject($json, $allowed, $strict);
    }

    /**
     * Asserts that a json fragment is a valid error source object.
     *
     * @param array $json
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidErrorSourceObject($json)
    {
        PHPUnit::assertIsArray(
            $json,
            Messages::ERROR_SOURCE_OBJECT_NOT_ARRAY
        );

        if (isset($json['pointer'])) {
            PHPUnit::assertIsString(
                $json['pointer'],
                Messages::ERROR_SOURCE_POINTER_IS_NOT_STRING
            );
            PHPUnit::assertStringStartsWith(
                '/',
                $json['pointer'],
                Messages::ERROR_SOURCE_POINTER_START
            );
        }

        if (isset($json['parameter'])) {
            PHPUnit::assertIsString(
                $json['parameter'],
                Messages::ERROR_SOURCE_PARAMETER_IS_NOT_STRING
            );
        }
    }
}
