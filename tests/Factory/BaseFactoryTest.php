<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Factory\BaseFactory;
use VGirol\JsonApiAssert\Factory\HelperFactory;
use VGirol\JsonApiAssert\Tests\TestCase;

class BaseFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function addToObject()
    {
        $object = 'test';
        $key = 'key';
        $value = 'value';

        $factory = $this->getMockForAbstractClass(BaseFactory::class);

        PHPUnit::assertObjectNotHasAttribute($object, $factory);

        $factory->addToObject($object, $key, $value);

        PHPUnit::assertObjectHasAttribute($object, $factory);
        PHPUnit::assertEquals(
            [$key => $value],
            $factory->{$object}
        );
    }

    /**
     * @test
     */
    public function addToArray()
    {
        $object = 'test';
        $value1 = 'value1';
        $value2 = 'value2';

        $factory = $this->getMockForAbstractClass(BaseFactory::class);

        PHPUnit::assertObjectNotHasAttribute($object, $factory);

        $factory->addToArray($object, $value1);

        PHPUnit::assertObjectHasAttribute($object, $factory);
        PHPUnit::assertEquals(
            [$value1],
            $factory->{$object}
        );

        $factory->addToArray($object, $value2);

        PHPUnit::assertEquals(
            [$value1, $value2],
            $factory->{$object}
        );
    }
}
