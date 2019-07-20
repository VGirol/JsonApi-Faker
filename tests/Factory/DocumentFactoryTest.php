<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Factory\DocumentFactory;
use VGirol\JsonApiAssert\Factory\RelationshipFactory;
use VGirol\JsonApiAssert\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiAssert\Factory\ResourceObjectFactory;
use VGirol\JsonApiAssert\Tests\TestCase;

class DocumentFactoryTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function setIncluded()
    {
        $this->checkSetMethod(
            new DocumentFactory,
            'setIncluded',
            'included',
            [
                'included1'
            ],
            [
                'included2'
            ]
        );
    }

    /**
     * @test
     */
    public function setJsonapi()
    {
        $this->checkSetMethod(
            new DocumentFactory,
            'setJsonapi',
            'jsonapi',
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
    public function toArrayWithErrors()
    {
        $meta = [
            'metaKey' => 'test'
        ];
        $links = [
            'self' => 'url'
        ];
        $jsonapi = [
            'version' => 'test'
        ];
        $errors = [
            [
                'id' => 'errorId',
                'code' => 'secret'
            ]
        ];

        $expected = [
            'meta' => $meta,
            'links' => $links,
            'errors' => $errors,
            'jsonapi' => $jsonapi
        ];

        $factory = new DocumentFactory;
        $factory->setMeta($meta)
            ->setLinks($links)
            ->setJsonapi($jsonapi)
            ->setErrors($errors);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function toArrayWithData()
    {
        $meta = [
            'metaKey' => 'test'
        ];
        $links = [
            'self' => 'url'
        ];
        $jsonapi = [
            'version' => 'test'
        ];

        $rel_id = '456';
        $rel_type = 'test';
        $ri = new ResourceIdentifierFactory;
        $ri->setId($rel_id);
        $ri->setResourceType($rel_type);

        $relationship = new RelationshipFactory;
        $relationship->setData($ri);

        $id = '123';
        $type = 'parent';
        $attributes = [
            'key' => 'value'
        ];
        $name = 'test';
        $data = [
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
        $ro = new ResourceObjectFactory;
        $ro->setId($id)
            ->setResourceType($type)
            ->setAttributes($attributes)
            ->addRelationship($name, $relationship);

        $rel_attributes = [
            'key1' => 'value1',
            'key2' => 'value2'
        ];
        $included = [
            'type' => $rel_type,
            'id' => $rel_id,
            'attributes' => $rel_attributes
        ];
        $inc = new ResourceObjectFactory;
        $inc->setId($rel_id)
            ->setResourceType($rel_type)
            ->setAttributes($rel_attributes);

        $expected = [
            'meta' => $meta,
            'links' => $links,
            'data' => $data,
            'included' => $included,
            'jsonapi' => $jsonapi
        ];

        $factory = new DocumentFactory;
        $factory->setMeta($meta)
            ->setLinks($links)
            ->setJsonapi($jsonapi)
            ->setData($ro)
            ->setIncluded($inc);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }
}
