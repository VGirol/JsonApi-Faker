<?php

namespace VGirol\JsonApiFaker\Tests;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;
use VGirol\JsonApiFaker\Factory\CollectionFactory;
use VGirol\JsonApiFaker\Factory\DocumentFactory;
use VGirol\JsonApiFaker\Factory\ErrorFactory;
use VGirol\JsonApiFaker\Factory\JsonapiFactory;
use VGirol\JsonApiFaker\Factory\RelationshipFactory;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Factory\ResourceObjectFactory;
use VGirol\JsonApiFaker\Generator;
use VGirol\JsonApiFaker\Messages;
use VGirol\JsonApiFaker\Tests\TestCase;

class GeneratorTest extends TestCase
{
    /**
     * @test
     */
    public function create()
    {
        $faker = new Generator;
        $obj = $faker->create('jsonapi');

        PHPUnit::assertIsObject($obj);
        PHPUnit::assertInstanceOf(JsonapiFactory::class, $obj);
    }

    /**
     * @test
     */
    public function createInexistantKey()
    {
        $key = 'inexistant';

        $this->expectException(JsonApiFakerException::class);
        $this->expectExceptionMessage(sprintf(Messages::FACTORY_INEXISTANT_KEY, $key));

        $faker = new Generator;
        $faker->create($key);
    }

    /**
     * @test
     */
    public function createForbiddenKey()
    {
        $key = 'forbidden';

        $this->expectException(JsonApiFakerException::class);
        $this->expectExceptionMessage(sprintf(Messages::FACTORY_FORBIDDEN_KEY, $key));

        $faker = new Generator;
        $faker->setFactory($key, null);
        $faker->create($key);
    }

    /**
     * @test
     */
    public function createWithCustomizedClass()
    {
        $key = 'dummy';
        $faker = new Generator;
        $ret = $faker->setFactory($key, DummyFactory::class);

        PHPUnit::assertSame($ret, $faker);

        $obj = $faker->create($key);

        PHPUnit::assertIsObject($obj);
        PHPUnit::assertInstanceOf(DummyFactory::class, $obj);
    }

    /**
     * @test
     * @dataProvider createObjectProvider
     */
    public function createObject($method, $class)
    {
        $faker = new Generator;
        $obj = $faker->{$method}();

        PHPUnit::assertIsObject($obj);
        PHPUnit::assertInstanceOf($class, $obj);
        PHPUnit::assertSame($faker, $obj->getGenerator());
    }

    public function createObjectProvider()
    {
        return [
            'collection' => [
                'collection',
                CollectionFactory::class
            ],
            'document' => [
                'document',
                DocumentFactory::class
            ],
            'error' => [
                'error',
                ErrorFactory::class
            ],
            'jsonapiObject' => [
                'jsonapiObject',
                JsonapiFactory::class
            ],
            'relationship' => [
                'relationship',
                RelationshipFactory::class
            ],
            'resourceIdentifier' => [
                'resourceIdentifier',
                ResourceIdentifierFactory::class
            ],
            'resourceObject' => [
                'resourceObject',
                ResourceObjectFactory::class
            ]
        ];
    }
}
