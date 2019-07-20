<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiAssert\Tests\TestCase;

class ResourceIdentifierFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function resourceIdentifierFactoryEmpty()
    {
        $expected = null;

        $factory = new ResourceIdentifierFactory;

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function resourceIdentifierFactoryEmptyWithMeta()
    {
        $key = 'key';
        $value = 'value';
        $expected = [
            'meta' => [
                $key => $value
            ]
        ];

        $factory = new ResourceIdentifierFactory;
        $factory->addToMeta($key, $value);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function resourceIdentifierFactory()
    {
        $id = '456';
        $type = 'test';
        $key = 'key';
        $value = 'value';
        $expected = [
            'type' => $type,
            'id' => $id,
            'meta' => [
                $key => $value
            ]
        ];

        $factory = new ResourceIdentifierFactory;
        $factory->setId($id);
        $factory->setResourceType($type);
        $factory->addToMeta($key, $value);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }
}
