<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiConstant\Members;
use VGirol\JsonApiFaker\Factory\RelationshipFactory;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Factory\ResourceObjectFactory;
use VGirol\JsonApiFaker\Generator;
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
            Members::LINK_SELF => 'url'
        ];
        $expected = [
            Members::TYPE => $type,
            Members::ID => $id,
            Members::ATTRIBUTES => $attributes,
            Members::META => $meta,
            Members::LINKS => $links
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
            Members::TYPE => $type,
            Members::ID => $id,
            Members::ATTRIBUTES => $attributes,
            Members::RELATIONSHIPS => [
                $name => [
                    Members::DATA => [
                        Members::TYPE => $rel_type,
                        Members::ID => $rel_id
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
            Members::META => $meta,
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
        $factory = (new ResourceObjectFactory)->setGenerator(new Generator);

        PHPUnit::assertEmpty($factory->getId());
        PHPUnit::assertEmpty($factory->getResourceType());
        PHPUnit::assertEmpty($factory->getAttributes());
        PHPUnit::assertEmpty($factory->getMeta());
        PHPUnit::assertEmpty($factory->getLinks());
        PHPUnit::assertEmpty($factory->getRelationships());

        $obj = $factory->fake();

        PHPUnit::assertSame($obj, $factory);
        PHPUnit::assertNotEmpty($factory->getId());
        PHPUnit::assertNotEmpty($factory->getResourceType());
        PHPUnit::assertNotEmpty($factory->getAttributes());
        PHPUnit::assertEquals(5, count($factory->getAttributes()));
        PHPUnit::assertNotEmpty($factory->getMeta());
        PHPUnit::assertEquals(5, count($factory->getMeta()));
        PHPUnit::assertNotEmpty($factory->getLinks());
        PHPUnit::assertEquals(1, count($factory->getLinks()));
        PHPUnit::assertEquals([Members::LINK_SELF], array_keys($factory->getLinks()));

        Assert::assertIsValidResourceObject($factory->toArray(), true);
    }
}
