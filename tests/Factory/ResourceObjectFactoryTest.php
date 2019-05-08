<?php
namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Factory\HelperFactory;
use VGirol\JsonApiAssert\Tests\TestCase;

class ResourceObjectFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function resourceObjectFactory()
    {
        $id = '456';
        $type = 'test';
        $attributes = [
            'key' => 'value'
        ];
        $expected = [
            'type' => $type,
            'id' => $id,
            'attributes' => $attributes
        ];

        $factory = HelperFactory::create('resource-object');
        $factory->setId($id);
        $factory->setResourceType($type);
        $factory->setAttributes($attributes);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function resourceObjectFactoryWithRelationships()
    {
        $rel_id = '456';
        $rel_type = 'test';
        $data = HelperFactory::create('resource-identifier');
        $data->setId($rel_id);
        $data->setResourceType($rel_type);

        $relationship = HelperFactory::create('relationship');
        $relationship->setData($data);

        $id = '123';
        $type = 'parent';
        $attributes = [
            'key' => 'value'
        ];
        $name = 'test';

        $expected = [
            'type' => $type,
            'id' => $id,
            'attributes' => $attributes,
            'relationships' => [
                $name => [
                    'data' => [
                        'type' => $rel_type,
                        'id' => $rel_id
                    ]
                ]
            ]
        ];

        $factory = HelperFactory::create('resource-object');
        $factory->setId($id);
        $factory->setResourceType($type);
        $factory->setAttributes($attributes);
        $factory->addRelationship($name, $relationship);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }
}
