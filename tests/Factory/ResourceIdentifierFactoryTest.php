<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Tests\TestCase;

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

    /**
     * @test
     */
    public function fake()
    {
        $factory = new ResourceIdentifierFactory;

        PHPUnit::assertEmpty($factory->id);
        PHPUnit::assertEmpty($factory->resourceType);

        $obj = $factory->fake();

        PHPUnit::assertSame($obj, $factory);
        PHPUnit::assertNotEmpty($factory->id);
        PHPUnit::assertNotEmpty($factory->resourceType);

        Assert::assertIsValidResourceIdentifierObject($factory->toArray(), true);
    }

    /**
     * @test
     */
    public function fakeWithoutMeta()
    {
        $factory = new ResourceIdentifierFactory;

        PHPUnit::assertEmpty($factory->meta);

        $factory->fake(ResourceIdentifierFactory::FAKE_NO_META);

        PHPUnit::assertEmpty($factory->meta);

        Assert::assertIsValidResourceIdentifierObject($factory->toArray(), true);
    }

    /**
     * @test
     */
    public function fakeWithMeta()
    {
        $factory = new ResourceIdentifierFactory;

        PHPUnit::assertEmpty($factory->meta);

        $factory->fake(ResourceIdentifierFactory::FAKE_WITH_META, 3);

        PHPUnit::assertNotEmpty($factory->meta);
        PHPUnit::assertEquals(3, count($factory->meta));

        Assert::assertIsValidResourceIdentifierObject($factory->toArray(), true);
    }
}
