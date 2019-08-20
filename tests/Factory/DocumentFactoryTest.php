<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiFaker\Factory\DocumentFactory;
use VGirol\JsonApiFaker\Factory\JsonapiFactory;
use VGirol\JsonApiFaker\Factory\RelationshipFactory;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Factory\ResourceObjectFactory;
use VGirol\JsonApiFaker\Testing\CheckMethods;
use VGirol\JsonApiFaker\Tests\TestCase;

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
        $jsonapi = (new JsonapiFactory)->setVersion('test');
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
            'jsonapi' => [
                'version' => 'test'
            ]
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
        $jsonapi = (new JsonapiFactory)->setVersion('test');

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
            'jsonapi' => [
                'version' => 'test'
            ]
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

    /**
     * @test
     */
    public function fake()
    {
        $factory = new DocumentFactory;

        PHPUnit::assertEmpty($factory->data);
        PHPUnit::assertEmpty($factory->errors);
        PHPUnit::assertEmpty($factory->links);
        PHPUnit::assertEmpty($factory->meta);
        PHPUnit::assertEmpty($factory->included);
        PHPUnit::assertEmpty($factory->jsonapi);

        $obj = $factory->fake();

        PHPUnit::assertSame($obj, $factory);

        PHPUnit::assertNotEmpty($factory->data);
        PHPUnit::assertEmpty($factory->errors);
        PHPUnit::assertNotEmpty($factory->links);
        PHPUnit::assertNotEmpty($factory->meta);
        PHPUnit::assertEmpty($factory->included);
        PHPUnit::assertNotEmpty($factory->jsonapi);
    }
}
