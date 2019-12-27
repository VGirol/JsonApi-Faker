<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiConstant\Members;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Tests\TestCase;

class ResourceIdentifierFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function resourceIdentifierFactoryEmpty()
    {
        $expected = [];

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
            Members::META => [
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
            Members::TYPE => $type,
            Members::ID => $id,
            Members::META => [
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

    /**
     * @test
     */
    public function fake()
    {
        $factory = new ResourceIdentifierFactory;

        PHPUnit::assertEmpty($factory->getId());
        PHPUnit::assertEmpty($factory->getResourceType());

        $obj = $factory->fake();

        PHPUnit::assertSame($obj, $factory);
        PHPUnit::assertNotEmpty($factory->getId());
        PHPUnit::assertNotEmpty($factory->getResourceType());

        PHPUnit::assertNotEmpty($factory->getMeta());
        PHPUnit::assertEquals(5, count($factory->getMeta()));

        Assert::assertIsValidResourceIdentifierObject($factory->toArray(), true);
    }
}
