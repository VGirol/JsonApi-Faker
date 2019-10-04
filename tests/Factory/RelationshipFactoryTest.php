<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Factory\CollectionFactory;
use VGirol\JsonApiFaker\Factory\RelationshipFactory;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Generator;
use VGirol\JsonApiFaker\Tests\TestCase;

class RelationshipFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function dataIsnull()
    {
        $meta = [
            'metaKey' => 'test'
        ];
        $links = [
            'self' => 'url'
        ];
        $expected = [
            'data' => null,
            'meta' => $meta,
            'links' => $links
        ];

        $factory = new RelationshipFactory;
        $factory->setMeta($meta)
            ->setLinks($links);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function dataIsSingleResourceIdentifier()
    {
        $id = '456';
        $type = 'test';
        $expected = [
            'data' => [
                'type' => $type,
                'id' => $id
            ]
        ];

        $data = new ResourceIdentifierFactory;
        $data->setId($id)
            ->setResourceType($type);

        $factory = new RelationshipFactory;
        $factory->setData($data);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function dataIsEmptyCollection()
    {
        $collection = [];
        $expected = [
            'data' => []
        ];

        $data = new CollectionFactory;
        $data->setCollection($collection);

        $factory = new RelationshipFactory;
        $factory->setData($data);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function dataIsResourceIdentifierCollection()
    {
        $array = [];
        $collection = [];
        for ($i = 1; $i < 5; $i++) {
            $id = strval($i * 10);
            $type = 'test';
            array_push(
                $array,
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

        $expected = [
            'data' => $array
        ];

        $data = new CollectionFactory;
        $data->setCollection($collection);

        $factory = new RelationshipFactory;
        $factory->setData($data);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function fake()
    {
        $factory = (new RelationshipFactory)->setGenerator(new Generator);

        PHPUnit::assertEmpty($factory->getMeta());
        PHPUnit::assertEmpty($factory->getLinks());
        PHPUnit::assertEmpty($factory->getData());

        $obj = $factory->fake();

        PHPUnit::assertSame($obj, $factory);
        PHPUnit::assertNotEmpty($factory->getMeta());
        PHPUnit::assertNotEmpty($factory->getLinks());
        PHPUnit::assertNotEmpty($factory->getData());

        $relationship = $obj->toArray();
        Assert::assertIsArrayOfObjects($relationship['data']);
        PHPUnit::assertEquals(5, count($relationship['data']));
        Assert::assertIsValidRelationshipObject($relationship, true);
    }
}
