<?php

namespace VGirol\JsonApiAssert;

use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * Some helpers for testing
 */
trait SetExceptionsTrait
{
    /**
     * Set the expected exception and message when defining a test that will fail.
     *
     * @param string|null $message
     * @return void
     */
    protected function setFailureException($message)
    {
        $this->expectException(ExpectationFailedException::class);
        if (!is_null($message)) {
            $this->expectExceptionMessage($message);
        }
    }

    /**
     * Set the expected exception and message when testing a call with invalid arguments to a method.
     *
     * @param integer $arg
     * @param string $type
     * @param mixed $value
     * @return void
     */
    protected function setInvalidArgumentException(int $arg, string $type, $value = null)
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegExp(
            \sprintf(
                '/Argument #%d%sof %s::%s\(\) must be a %s/',
                $arg,
                is_null($value) ? '[\s\S]*' : ' \(' . \gettype($value) . '#' . $value . '\)',
                '.*',
                '.*',
                \preg_quote($type)
            )
        );
    }
}
