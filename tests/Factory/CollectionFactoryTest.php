<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;
use VGirol\JsonApiFaker\Factory\CollectionFactory;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Messages;
use VGirol\JsonApiFaker\Tests\TestCase;

class CollectionFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function noCollection()
    {
        $factory = new CollectionFactory;

        $result = $factory->toArray();

        PHPUnit::assertNull($result);
    }

    /**
     * @test
     */
    public function emptyCollection()
    {
        $expected = [];
        $collection = [];

        $factory = new CollectionFactory;
        $obj = $factory->setCollection($collection);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
        PHPUnit::assertSame($obj, $factory);
    }

    /**
     * @test
     */
    public function resourceIdentifierCollection()
    {
        $expected = [];
        $collection = [];
        for ($i = 1; $i < 5; $i++) {
            $id = strval($i * 10);
            $type = 'test';
            array_push(
                $expected,
                [
                    'type' => $type,
                    'id' => $id
                ]
            );

            $factory = new ResourceIdentifierFactory;
            $factory->setId($id);
            $factory->setResourceType($type);
            array_push(
                $collection,
                $factory
            );
        }

        $factory = new CollectionFactory;
        $factory->setCollection($collection);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function changeEachItemOfTheCollection()
    {
        $expected = [];
        $collection = [];
        for ($i = 1; $i < 5; $i++) {
            $id = strval($i * 10);
            $type = 'test';
            array_push(
                $expected,
                [
                    'type' => $type,
                    'id' => $id
                ]
            );

            $factory = new ResourceIdentifierFactory;
            $factory->setId($id);
            $factory->setResourceType($type);
            array_push(
                $collection,
                $factory
            );
        }

        $factory = new CollectionFactory;
        $factory->setCollection($collection);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);

        array_walk($expected, function (&$item) {
            $item['meta'] = ['new' => $item['id']];
        });

        $obj = $factory->each(function ($item) {
            $item->addToMeta('new', $item->id);
        });
        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
        PHPUnit::assertSame($obj, $factory);
    }

    /**
     * @test
     */
    public function changeEachItemOfAnEmptyCollection()
    {
        $this->expectException(JsonApiFakerException::class);
        $this->expectExceptionMessage(Messages::ERROR_COLLECTION_NOT_SET);

        $factory = new CollectionFactory;
        $factory->each(function ($item) {
            $item->addToMeta('new', $item->id);
        });
    }

    /**
     * @test
     */
    public function mapEachItemOfTheCollection()
    {
        $expected = [];
        $collection = [];
        for ($i = 1; $i < 5; $i++) {
            $id = strval($i * 10);
            $type = 'test';
            array_push(
                $expected,
                [
                    'type' => "new{$type}",
                    'id' => $id
                ]
            );

            $factory = new ResourceIdentifierFactory;
            $factory->setId($id);
            $factory->setResourceType($type);
            array_push(
                $collection,
                $factory
            );
        }

        $factory = new CollectionFactory;
        $factory->setCollection($collection);

        $result = $factory->map(function ($item) {
            return [
                'type' => "new{$item->resourceType}",
                'id' => $item->id
            ];
        });

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function mapEachItemOfAnEmptyCollection()
    {
        $this->expectException(JsonApiFakerException::class);
        $this->expectExceptionMessage(Messages::ERROR_COLLECTION_NOT_SET);

        $factory = new CollectionFactory;
        $factory->map(function ($item) {
            return [
                'type' => "new{$item->resourceType}",
                'id' => $item->id
            ];
        });
    }

    /**
     * @test
     */
    public function fake()
    {
        $factory = new CollectionFactory;

        PHPUnit::assertEmpty($factory->array);

        $obj = $factory->fake();

        PHPUnit::assertSame($obj, $factory);
        PHPUnit::assertNotEmpty($factory->array);
        PHPUnit::assertIsArray($factory->array);
        PHPUnit::assertEquals(5, count($factory->array));

        Assert::assertIsArrayOfObjects($factory->array);
    }
}
