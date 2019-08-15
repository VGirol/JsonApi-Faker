<?php

namespace VGirol\JsonApiFaker\Tests;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiFaker\Factory\JsonapiFactory;
use VGirol\JsonApiFaker\Generator;
use VGirol\JsonApiFaker\Messages;
use VGirol\JsonApiFaker\Tests\TestCase;

class FakerFactoryTest extends TestCase
{
    // /**
    //  * @test
    //  */
    // public function getClassName()
    // {
    //     $name = HelperFactory::getClassName('resource-object');

    //     PHPUnit::assertIsString($name);
    //     PHPUnit::assertEquals(ResourceObjectFactory::class, $name);
    // }

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

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf(Messages::FACTORY_INEXISTANT_KEY, $key));

        $faker = new Generator;
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
}

class DummyFactory
{ }
