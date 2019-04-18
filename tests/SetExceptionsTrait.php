<?php

namespace VGirol\JsonApiAssert\Tests;

use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;

trait SetExceptionsTrait
{
    protected function setFailureException($msg)
    {
        $this->expectException(ExpectationFailedException::class);
        if (!is_null($msg)) {
            $this->expectExceptionMessage($msg);
        }
    }

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
