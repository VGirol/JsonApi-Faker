<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiFaker\Factory\CollectionFactory;
use VGirol\JsonApiFaker\Factory\DocumentFactory;
use VGirol\JsonApiFaker\Factory\ErrorFactory;
use VGirol\JsonApiFaker\Factory\JsonapiFactory;
use VGirol\JsonApiFaker\Factory\Options;
use VGirol\JsonApiFaker\Factory\RelationshipFactory;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Factory\ResourceObjectFactory;
use VGirol\JsonApiFaker\Generator;
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
            'getIncluded',
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
            'getJsonapi',
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
        $error = (new ErrorFactory)->setId('errorId')->set('code', 'secret');
        $errors = [
            $error->toArray()
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
            ->addError($error);

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
    public function fakeSingleResource()
    {
        $factory = (new DocumentFactory)->setGenerator(new Generator);

        PHPUnit::assertEmpty($factory->getData());
        PHPUnit::assertEmpty($factory->getErrors());
        PHPUnit::assertEmpty($factory->getLinks());
        PHPUnit::assertEmpty($factory->getMeta());
        PHPUnit::assertEmpty($factory->getIncluded());
        PHPUnit::assertEmpty($factory->getJsonapi());

        $obj = $factory->fake();

        PHPUnit::assertSame($obj, $factory);

        PHPUnit::assertEmpty($factory->getErrors());
        PHPUnit::assertNotEmpty($factory->getLinks());
        PHPUnit::assertNotEmpty($factory->getMeta());
        PHPUnit::assertEmpty($factory->getIncluded());
        PHPUnit::assertNotEmpty($factory->getJsonapi());

        $data = $factory->getData();
        PHPUnit::assertNotEmpty($data);
        PHPUnit::assertInstanceOf(ResourceObjectFactory::class, $data);
    }

    /**
     * @test
     */
    public function fakeResourceCollection()
    {
        $factory = (new DocumentFactory)->setGenerator(new Generator);

        PHPUnit::assertEmpty($factory->getData());
        PHPUnit::assertEmpty($factory->getErrors());
        PHPUnit::assertEmpty($factory->getLinks());
        PHPUnit::assertEmpty($factory->getMeta());
        PHPUnit::assertEmpty($factory->getIncluded());
        PHPUnit::assertEmpty($factory->getJsonapi());

        $obj = $factory->fake(Options::FAKE_COLLECTION | Options::FAKE_RESOURCE_IDENTIFIER);

        PHPUnit::assertSame($obj, $factory);

        PHPUnit::assertEmpty($factory->getErrors());
        PHPUnit::assertNotEmpty($factory->getLinks());
        PHPUnit::assertNotEmpty($factory->getMeta());
        PHPUnit::assertEmpty($factory->getIncluded());
        PHPUnit::assertNotEmpty($factory->getJsonapi());

        $data = $factory->getData();
        PHPUnit::assertNotEmpty($data);
        PHPUnit::assertInstanceOf(CollectionFactory::class, $data);
        PHPUnit::assertCount(3, $data->getCollection());
    }
}
