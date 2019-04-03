<?php
namespace VGirol\JsonApiAssert\Asserts;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Messages;

trait AssertErrorsObject
{
    /**
     * Asserts that an errors object is valid.
     *
     * @param array     $errors
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidErrorsObject($errors, $strict)
    {
        static::assertIsArrayOfObjects(
            $errors,
            Messages::ERRORS_OBJECT_NOT_ARRAY
        );

        foreach ($errors as $error) {
            static::assertIsValidErrorObject($error, $strict);
        }
    }

    /**
     * Asserts that an error object is valid.
     *
     * @param array     $error
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidErrorObject($error, $strict)
    {
        PHPUnit::assertIsArray(
            $error,
            Messages::ERROR_OBJECT_NOT_ARRAY
        );

        PHPUnit::assertNotEmpty(
            $error,
            Messages::ERROR_OBJECT_NOT_EMPTY
        );

        $allowed = ['id', 'links', 'status', 'code', 'title', 'details', 'source', 'meta'];
        static::assertContainsOnlyAllowedMembers(
            $allowed,
            $error
        );

        if (isset($error['status'])) {
            PHPUnit::assertIsString(
                $error['status'],
                Messages::ERROR_STATUS_IS_NOT_STRING
            );
        }

        if (isset($error['code'])) {
            PHPUnit::assertIsString(
                $error['code'],
                Messages::ERROR_CODE_IS_NOT_STRING
            );
        }

        if (isset($error['title'])) {
            PHPUnit::assertIsString(
                $error['title'],
                Messages::ERROR_TITLE_IS_NOT_STRING
            );
        }

        if (isset($error['details'])) {
            PHPUnit::assertIsString(
                $error['details'],
                Messages::ERROR_DETAILS_IS_NOT_STRING
            );
        }

        if (isset($error['source'])) {
            static::assertIsValidErrorSourceObject($error['source']);
        }

        if (isset($error['links'])) {
            static::assertIsValidErrorLinksObject($error['links'], $strict);
        }

        if (isset($error['meta'])) {
            static::assertIsValidMetaObject($error['meta'], $strict);
        }
    }

    /**
     * Asserts that an error links object is valid.
     *
     * @param array     $links
     * @param boolean   $strict         If true, excludes not safe characters when checking members name
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidErrorLinksObject($links, $strict)
    {
        $allowed = ['about'];
        static::assertIsValidLinksObject($links, $allowed, $strict);
    }

    /**
     * Asserts that an error source object is valid.
     *
     * @param array $source
     *
     * @throws PHPUnit\Framework\ExpectationFailedException
     */
    public static function assertIsValidErrorSourceObject($source)
    {
        PHPUnit::assertIsArray(
            $source,
            Messages::ERROR_SOURCE_OBJECT_NOT_ARRAY
        );

        if (isset($source['pointer'])) {
            PHPUnit::assertIsString(
                $source['pointer'],
                Messages::ERROR_SOURCE_POINTER_IS_NOT_STRING
            );
            PHPUnit::assertStringStartsWith(
                '/',
                $source['pointer'],
                Messages::ERROR_SOURCE_POINTER_START
            );
        }

        if (isset($source['parameter'])) {
            PHPUnit::assertIsString(
                $source['parameter'],
                Messages::ERROR_SOURCE_PARAMETER_IS_NOT_STRING
            );
        }
    }
}
