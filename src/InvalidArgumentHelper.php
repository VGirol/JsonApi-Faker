<?php
declare (strict_types = 1);

/*
 * This file is inspired from PHPUnit\Util\InvalidArgumentHelper.
 */
namespace VGirol\JsonApiAssert;

/**
 * Factory for VGirol\JsonApiAssert\Exception
 *
 * @internal
 */
final class InvalidArgumentHelper
{
    /**
     * Creates a new instance of VGirol\JsonApiAssert\Exception with customized message.
     *
     * @param integer $argument
     * @param string $type
     * @param mixed $value
     * @return Exception
     */
    public static function factory(int $argument, string $type, $value = null): Exception
    {
        $stack = \debug_backtrace();

        return new Exception(
            \sprintf(
                Exception::INVALID_ARGUMENT,
                $argument,
                $value !== null ? ' (' . \gettype($value) . '#' . $value . ')' : ' (No Value)',
                $stack[1]['class'],
                $stack[1]['function'],
                $type
            )
        );
    }
}
