<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Factory\RelationshipFactory;
use VGirol\JsonApiAssert\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiAssert\Factory\ResourceObjectFactory;
use VGirol\JsonApiAssert\Tests\TestCase;

class ResourceObjectFactoryTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function setAttributes()
    {
        $this->checkSetMethod(
            new ResourceObjectFactory,
            'setAttributes',
            'attributes',
            [
                'attr1' => 'value1'
            ],
            [
                'attr2' => 'value2'
            ]
        );
    }

    /**
     * @test
     */
    public function addAttribute()
    {
        $this->checkAddSingle(
            new ResourceObjectFactory,
            'addAttribute',
            'attributes',
            [
                'attr1' => 'value1'
            ],
            [
                'attr2' => 'value2'
            ]
        );
    }

    /**
     * @test
     */
    public function addAttributes()
    {
        $this->checkAddMulti(
            new ResourceObjectFactory,
            'addAttributes',
            'attributes',
            [
                'attr1' => 'value1',
                'attr2' => 'value2'
            ],
            [
                'attr3' => 'value3',
                'attr4' => 'value4'
            ]
        );
    }

    /**
     * @test
     */
    public function addRelationship()
    {
        $this->checkAddSingle(
            new ResourceObjectFactory,
            'addRelationship',
            'relationships',
            [
                'relation1' => 'value1'
            ],
            [
                'relation2' => 'value2'
            ]
        );
    }

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
        $meta = [
            'metaKey' => 'test'
        ];
        $links = [
            'self' => 'url'
        ];
        $expected = [
            'type' => $type,
            'id' => $id,
            'attributes' => $attributes,
            'meta' => $meta,
            'links' => $links
        ];

        $factory = new ResourceObjectFactory;
        $factory->setId($id)
            ->setResourceType($type)
            ->setAttributes($attributes)
            ->setMeta($meta)
            ->setLinks($links);

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
        $data = new ResourceIdentifierFactory;
        $data->setId($rel_id);
        $data->setResourceType($rel_type);

        $relationship = new RelationshipFactory;
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

        $factory = new ResourceObjectFactory;
        $factory->setId($id);
        $factory->setResourceType($type);
        $factory->setAttributes($attributes);
        $factory->addRelationship($name, $relationship);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }
}
