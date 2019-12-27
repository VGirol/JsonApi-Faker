<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiConstant\Members;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;
use VGirol\JsonApiFaker\Factory\CollectionFactory;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Generator;
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
                    Members::TYPE => $type,
                    Members::ID => $id
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
                    Members::TYPE => $type,
                    Members::ID => $id
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
            $item[Members::META] = ['new' => $item[Members::ID]];
        });

        $obj = $factory->each(
            /**
             * @param ResourceIdentifierFactory $item
             */
            function ($item) {
                $item->addToMeta('new', $item->getId());
            }
        );
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
                    Members::TYPE => "new{$type}",
                    Members::ID => $id
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

        $result = $factory->map(
            /**
             * @param ResourceIdentifierFactory $item
             */
            function ($item) {
                return [
                    Members::TYPE => 'new' . $item->getResourceType(),
                    Members::ID => $item->getId()
                ];
            }
        );

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
                Members::TYPE => "new{$item->resourceType}",
                Members::ID => $item->id
            ];
        });
    }

    /**
     * @test
     */
    public function fake()
    {
        $factory = (new CollectionFactory)->setGenerator(new Generator);

        PHPUnit::assertEmpty($factory->getCollection());

        $obj = $factory->fake();

        PHPUnit::assertSame($obj, $factory);

        $collection = $factory->getCollection();
        PHPUnit::assertNotEmpty($collection);
        PHPUnit::assertIsArray($collection);
        PHPUnit::assertEquals(5, count($collection));

        Assert::assertIsArrayOfObjects($collection);
    }
}
