<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Messages;
use VGirol\JsonApiFaker\Tests\TestCase;

class BaseFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function addToObject()
    {
        $object = 'test';
        $values = [
            'key1' => 'value1',
            'key2' => 'value2'
        ];

        $factory = $this->getMockForAbstractClass(BaseFactory::class);

        PHPUnit::assertObjectNotHasAttribute($object, $factory);

        foreach ($values as $key => $value) {
            $factory->addToObject($object, $key, $value);
        }

        PHPUnit::assertObjectHasAttribute($object, $factory);
        PHPUnit::assertEquals(
            $values,
            $factory->{$object}
        );
    }

    /**
     * @test
     */
    public function addToArray()
    {
        $object = 'test';
        $values = [
            'value1',
            'value2'
        ];

        $factory = $this->getMockForAbstractClass(BaseFactory::class);

        PHPUnit::assertObjectNotHasAttribute($object, $factory);

        foreach ($values as $key => $value) {
            $factory->addToArray($object, $value);
        }

        PHPUnit::assertObjectHasAttribute($object, $factory);
        PHPUnit::assertEquals(
            $values,
            $factory->{$object}
        );
    }

    /**
     * @test
     */
    public function toJson()
    {
        $obj = new class extends BaseFactory
        {
            public function toArray(): ?array
            {
                return [
                    'attr' => 'value',
                    'arr' => [
                        'first',
                        'second'
                    ]
                ];
            }

            public function fake()
            {
                return $this;
            }
        };

        $json = $obj->toJson();
        $expected = '{"attr":"value","arr":["first","second"]}';

        PHPUnit::assertEquals($expected, $json);
    }

    /**
     * @test
     */
    public function toJsonFailed()
    {
        $obj = new class extends BaseFactory
        {
            public function toArray(): ?array
            {
                return [
                    'stream' => tmpfile()
                ];
            }

            public function fake()
            {
                return $this;
            }
        };

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(
            sprintf(Messages::JSON_ENCODE_ERROR, 'Type is not supported')
        );

        $obj->toJson();
    }
}
