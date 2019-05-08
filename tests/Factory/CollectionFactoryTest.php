<?php
namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Factory\HelperFactory;
use VGirol\JsonApiAssert\Tests\TestCase;

class CollectionFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function noCollection()
    {
        $expected = null;

        $factory = HelperFactory::create('collection');

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

        $factory = HelperFactory::create('collection');
        $factory->setCollection($collection);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
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

            $factory = HelperFactory::create('resource-identifier');
            $factory->setId($id);
            $factory->setResourceType($type);
            array_push(
                $collection,
                $factory
            );
        }

        $factory = HelperFactory::create('collection');
        $factory->setCollection($collection);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }
}
