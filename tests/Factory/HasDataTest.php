<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\CollectionFactory;
use VGirol\JsonApiFaker\Factory\HasData;
use VGirol\JsonApiFaker\Factory\Options;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Testing\CheckMethods;
use VGirol\JsonApiFaker\Tests\TestCase;

class HasDataTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function setData()
    {
        $this->checkSetMethod(
            $this->getMockForTrait(HasData::class),
            'setData',
            'data',
            'test',
            'another test'
        );
    }

    /**
     * @test
     */
    public function fakeData()
    {
        $mock = new class extends BaseFactory
        {
            use HasData;

            public function toArray(): ?array
            {
                return null;
            }

            public function fake()
            {
                return $this;
            }
        };

        PHPUnit::assertEmpty($mock->data);

        $obj = $mock->fakeData();

        PHPUnit::assertSame($obj, $mock);

        PHPUnit::assertInstanceOf(CollectionFactory::class, $mock->data);

        $array = $mock->data->toArray();
        PHPUnit::assertEquals(5, count($array));

        Assert::assertIsValidResourceObjectCollection($array, true);
    }

    /**
     * @test
     */
    public function fakeDataResourceObjectCollection()
    {
        $mock = new class extends BaseFactory
        {
            use HasData;

            public function toArray(): ?array
            {
                return null;
            }

            public function fake()
            {
                return $this;
            }
        };

        PHPUnit::assertEmpty($mock->data);

        $obj = $mock->fakeData(Options::FAKE_RESOURCE_OBJECT | Options::FAKE_COLLECTION, 3);

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->data);
        PHPUnit::assertInstanceOf(CollectionFactory::class, $mock->data);

        $array = $mock->data->toArray();

        Assert::assertIsArrayOfObjects($array);
        PHPUnit::assertEquals(3, count($array));
        Assert::assertIsValidResourceObjectCollection($array, true);
    }

    /**
     * @test
     */
    public function fakeDataSingleResourceIdentifier()
    {
        $mock = new class extends BaseFactory
        {
            use HasData;

            public function toArray(): ?array
            {
                return null;
            }

            public function fake()
            {
                return $this;
            }
        };

        PHPUnit::assertEmpty($mock->data);

        $obj = $mock->fakeData(Options::FAKE_RESOURCE_IDENTIFIER | Options::FAKE_SINGLE);

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->data);
        PHPUnit::assertInstanceOf(ResourceIdentifierFactory::class, $mock->data);

        Assert::assertIsNotArrayOfObjects($mock->data->toArray());
        Assert::assertIsValidResourceIdentifierObject($mock->data->toArray(), true);
    }

    /**
     * @test
     */
    public function fakeDataNull()
    {
        $mock = new class extends BaseFactory
        {
            use HasData;

            public function toArray(): ?array
            {
                return null;
            }

            public function fake()
            {
                return $this;
            }
        };

        PHPUnit::assertEmpty($mock->data);

        $count = 0;
        for ($i = 0; $i < 10; $i++) {
            $options = Options::FAKE_RESOURCE_IDENTIFIER | Options::FAKE_SINGLE | Options::FAKE_CAN_BE_NULL;
            $obj = $mock->fakeData($options);

            PHPUnit::assertSame($obj, $mock);

            if ($mock->data === null) {
                PHPUnit::assertTrue($mock->dataHasBeenSet());
                $count++;
            }
        }

        PHPUnit::assertGreaterThan(0, $count);
    }
}
