<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Factory\RelationshipFactory;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Factory\ResourceObjectFactory;
use VGirol\JsonApiFaker\Tests\TestCase;

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

    /**
     * @test
     */
    public function emptyResourceObjectFactory()
    {
        $meta = [
            'metaKey' => 'test'
        ];

        $expected = [
            'meta' => $meta,
        ];

        $factory = new ResourceObjectFactory;
        $factory->setMeta($meta);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function fake()
    {
        $factory = new ResourceObjectFactory;

        PHPUnit::assertEmpty($factory->id);
        PHPUnit::assertEmpty($factory->resourceType);
        PHPUnit::assertEmpty($factory->attributes);
        PHPUnit::assertEmpty($factory->meta);
        PHPUnit::assertEmpty($factory->links);
        PHPUnit::assertEmpty($factory->relationships);

        $obj = $factory->fake();

        PHPUnit::assertSame($obj, $factory);
        PHPUnit::assertNotEmpty($factory->id);
        PHPUnit::assertNotEmpty($factory->resourceType);
        PHPUnit::assertNotEmpty($factory->attributes);
        PHPUnit::assertEquals(5, count($factory->attributes));

        Assert::assertIsValidResourceObject($factory->toArray(), true);
    }

    /**
     * @test
     */
    public function fakeWithoutAnything()
    {
        $factory = new ResourceObjectFactory;

        PHPUnit::assertEmpty($factory->meta);

        $factory->fake(ResourceObjectFactory::FAKE_NO_META | ResourceObjectFactory::FAKE_NO_LINKS);

        PHPUnit::assertEmpty($factory->meta);
        PHPUnit::assertEmpty($factory->links);

        Assert::assertIsValidResourceObject($factory->toArray(), true);
    }

    /**
     * @test
     */
    public function fakeWithAll()
    {
        $factory = new ResourceObjectFactory;

        PHPUnit::assertEmpty($factory->meta);

        $factory->fake(
            ResourceObjectFactory::FAKE_WITH_META | ResourceObjectFactory::FAKE_WITH_LINKS,
            3,
            2
        );

        PHPUnit::assertEquals(3, count($factory->attributes));
        PHPUnit::assertNotEmpty($factory->meta);
        PHPUnit::assertEquals(2, count($factory->meta));
        PHPUnit::assertNotEmpty($factory->links);
        PHPUnit::assertEquals(1, count($factory->links));
        PHPUnit::assertEquals(['self'], array_keys($factory->links));

        Assert::assertIsValidResourceObject($factory->toArray(), true);
    }
}
