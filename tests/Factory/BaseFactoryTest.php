<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Generator;
use VGirol\JsonApiFaker\Messages;
use VGirol\JsonApiFaker\Tests\TestCase;

class BaseFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function setGenerator()
    {
        $generator = new Generator;

        $factory = $this->getMockForAbstractClass(BaseFactory::class);

        PHPUnit::assertNull($factory->getGenerator());

        $obj = $factory->setGenerator($generator);

        PHPUnit::assertSame($obj, $factory);
        PHPUnit::assertSame($generator, $factory->getGenerator());
    }

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
            $obj = $factory->addToObject($object, $key, $value);
            PHPUnit::assertSame($obj, $factory);
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
            $obj = $factory->addToArray($object, $value);
            PHPUnit::assertSame($obj, $factory);
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
        $obj = new class extends BaseFactory {
            public function toArray(): ?array
            {
                return [
                    'attr' => 'value with <, &, \' and ".',
                    'arr' => [
                        'first',
                        'second'
                    ],
                    'float' => 3.0
                ];
            }

            public function fake()
            {
                return $this;
            }
        };

        $json = $obj->toJson();
        $expected = '{"attr":"value with <, &, \' and \".","arr":["first","second"],"float":3.0}';

        PHPUnit::assertEquals($expected, $json);
    }

    /**
     * @test
     */
    public function toJsonFailed()
    {
        $obj = new class extends BaseFactory {
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

        $this->expectException(JsonApiFakerException::class);
        $this->expectExceptionMessage(
            sprintf(Messages::JSON_ENCODE_ERROR, 'Type is not supported')
        );

        $obj->toJson();
    }

    /**
     * @test
     */
    public function fakeMemberName()
    {
        $obj = new class extends BaseFactory {
            public function toArray(): ?array
            {
                return [];
            }

            public function fake()
            {
                return $this;
            }

            public function test($name)
            {
                $faker = \Faker\Factory::create();

                return $this->fakeMemberName($faker, $name);
            }
        };

        $in = 'test';
        $expected = 'test';
        $name = $obj->test($in);
        PHPUnit::assertEquals($expected, $name);

        $in = null;
        $name = $obj->test($in);
        PHPUnit::assertNotNull($name);
        PHPUnit::assertIsString($name);

        $in = 123;
        $name = $obj->test($in);
        PHPUnit::assertNotNull($name);
        PHPUnit::assertIsString($name);
        PHPUnit::assertNotEquals(strval($in), $name);

        $in = '/test[0-9]{3}/';
        $name = $obj->test($in);
        PHPUnit::assertNotNull($name);
        PHPUnit::assertIsString($name);
        PHPUnit::assertNotEquals($in, $name);
        PHPUnit::assertRegExp($in, $name);
    }

    /**
     * @test
     */
    public function fakeValue()
    {
        $obj = new class extends BaseFactory {
            public function toArray(): ?array
            {
                return [];
            }

            public function fake()
            {
                return $this;
            }

            public function test($providers)
            {
                $faker = \Faker\Factory::create();

                return $this->fakeValue($faker, $providers);
            }
        };

        $in = null;
        $value = $obj->test($in);
        PHPUnit::assertNull($value);

        $in = ['boolean'];
        $value = $obj->test($in);
        PHPUnit::assertNotNull($value);
        PHPUnit::assertIsBool($value);

        $in = [];
        $value = $obj->test($in);
        PHPUnit::assertNotNull($value);
    }
}
