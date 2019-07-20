<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Factory\CollectionFactory;
use VGirol\JsonApiAssert\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiAssert\Tests\TestCase;

class CollectionFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function noCollection()
    {
        $expected = null;

        $factory = new CollectionFactory;

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
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
}
