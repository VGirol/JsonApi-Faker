<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Factory\JsonapiFactory;
use VGirol\JsonApiAssert\Tests\TestCase;

class JsonapiFactoryTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function setVersion()
    {
        $this->checkSetMethod(
            new JsonapiFactory,
            'setVersion',
            'version',
            'version1',
            'version2'
        );
    }

    /**
     * @test
     */
    public function toArrayEmpty()
    {
        $expected = [];

        $factory = new JsonapiFactory;

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function toArrayWithoutMeta()
    {
        $version = '1.0';
        $expected = [
            'version' => $version
        ];

        $factory = new JsonapiFactory;
        $factory->setVersion($version);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function toArrayWithMeta()
    {
        $key = 'key';
        $value = 'value';
        $expected = [
            'meta' => [
                $key => $value
            ]
        ];

        $factory = new JsonapiFactory;
        $factory->addToMeta($key, $value);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }
}
