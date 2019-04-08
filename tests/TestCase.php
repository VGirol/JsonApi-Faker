<?php

namespace VGirol\JsonApiAssert\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    protected function getPhpunitExceptionText(int $argument, string $type, $value = null)
    {
        return \sprintf(
            '/Argument #%d%sof %s::%s\(\) must be a %s/',
            $argument,
            is_null($value) ? '.*' : ' \(' . \gettype($value) . '#' . $value . '\)',
            '.*',
            '.*',
            $type
        );
    }
}
