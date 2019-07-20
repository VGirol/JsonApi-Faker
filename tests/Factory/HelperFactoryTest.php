<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Factory\HelperFactory;
use VGirol\JsonApiAssert\Factory\JsonapiFactory;
use VGirol\JsonApiAssert\Factory\ResourceObjectFactory;
use VGirol\JsonApiAssert\Tests\TestCase;

class HelperFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function getClassName()
    {
        $name = HelperFactory::getClassName('resource-object');

        PHPUnit::assertIsString($name);
        PHPUnit::assertEquals(ResourceObjectFactory::class, $name);
    }

    /**
     * @test
     */
    public function getClassNameInexistantKey()
    {
        $key = 'inexistant';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf(HelperFactory::ERROR_INEXISTANT_KEY, $key));

        HelperFactory::getClassName($key);
    }

    /**
     * @test
     */
    public function getClassNameWithCustomizedClass()
    {
        $factory = new class extends HelperFactory
        {
            protected static function getAliases(): array
            {
                return array_merge(parent::getAliases(), [
                    'jsonapi' => 'customized'
                ]);
            }
        };
        $name = $factory->getClassName('jsonapi');

        PHPUnit::assertIsString($name);
        PHPUnit::assertEquals('customized', $name);
    }

    /**
     * @test
     */
    public function create()
    {
        $obj = HelperFactory::create('jsonapi');

        PHPUnit::assertIsObject($obj);
        PHPUnit::assertInstanceOf(JsonapiFactory::class, $obj);
    }
}
