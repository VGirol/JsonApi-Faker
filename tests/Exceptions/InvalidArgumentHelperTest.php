<?php
namespace VGirol\JsonApiAssert\Tests\Exceptions;

use VGirol\JsonApiAssert\InvalidArgumentException;
use VGirol\JsonApiAssert\InvalidArgumentHelper;
use VGirol\JsonApiAssert\Tests\TestCase;

class InvalidargumentHelperTest extends TestCase
{
    /**
     * @test
     */
    public function invalidargumentHelper()
    {
        $arg = 3;
        $type = 'string';
        $value = 666;
        $expected = \sprintf(
            InvalidArgumentException::MESSAGE,
            $arg,
            ' (' . \gettype($value) . '#' . $value . ')',
            'VGirol\JsonApiAssert\Tests\Exceptions\InvalidargumentHelperTest',
            'invalidargumentHelper',
            $type
        );

        $e = InvalidArgumentHelper::factory($arg, $type, $value);

        $this->assertEquals($expected, $e->getMessage());
    }
}
