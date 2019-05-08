<?php
namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Factory\HelperFactory;
use VGirol\JsonApiAssert\Tests\TestCase;

class RelationshipFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function dataIsnull()
    {
        $expected = [
            'data' => null
        ];

        $factory = HelperFactory::create('relationship');

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

        $data = HelperFactory::create('resource-identifier');
        $data->setId($id);
        $data->setResourceType($type);

        $factory = HelperFactory::create('relationship');
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

        $data = HelperFactory::create('collection');
        $data->setCollection($collection);

        $factory = HelperFactory::create('relationship');
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

            $factory = HelperFactory::create('resource-identifier');
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

        $data = HelperFactory::create('collection');
        $data->setCollection($collection);

        $factory = HelperFactory::create('relationship');
        $factory->setData($data);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }
}
