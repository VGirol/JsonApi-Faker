<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\CollectionFactory;
use VGirol\JsonApiFaker\Factory\HasData;
use VGirol\JsonApiFaker\Factory\Options;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Generator;
use VGirol\JsonApiFaker\Messages;
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
            'getData',
            (new Generator)->resourceIdentifier()->fake(),
            (new Generator)->resourceIdentifier()->fake()
        );
    }

    /**
     * @test
     */
    public function setDataFailed()
    {
        $mock = $this->getMockForTrait(HasData::class);

        $this->expectException(JsonApiFakerException::class);
        $this->expectExceptionMessage(Messages::SET_DATA_BAD_TYPE);

        $mock->setData('error');
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

        $mock->setGenerator(new Generator);

        PHPUnit::assertEmpty($mock->getData());

        $obj = $mock->fakeData();

        PHPUnit::assertSame($obj, $mock);

        PHPUnit::assertInstanceOf(CollectionFactory::class, $mock->getData());

        $array = $mock->getData()->toArray();
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

        $mock->setGenerator(new Generator);

        PHPUnit::assertEmpty($mock->getData());

        $obj = $mock->fakeData(Options::FAKE_RESOURCE_OBJECT | Options::FAKE_COLLECTION, 3);

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->getData());
        PHPUnit::assertInstanceOf(CollectionFactory::class, $mock->getData());

        $array = $mock->getData()->toArray();

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

        $mock->setGenerator(new Generator);

        PHPUnit::assertEmpty($mock->getData());

        $obj = $mock->fakeData(Options::FAKE_RESOURCE_IDENTIFIER | Options::FAKE_SINGLE);

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->getData());
        PHPUnit::assertInstanceOf(ResourceIdentifierFactory::class, $mock->getData());

        Assert::assertIsNotArrayOfObjects($mock->getData()->toArray());
        Assert::assertIsValidResourceIdentifierObject($mock->getData()->toArray(), true);
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

        $mock->setGenerator(new Generator);

        PHPUnit::assertEmpty($mock->getData());

        $count = 0;
        for ($i = 0; $i < 10; $i++) {
            $options = Options::FAKE_RESOURCE_IDENTIFIER | Options::FAKE_SINGLE | Options::FAKE_CAN_BE_NULL;
            $obj = $mock->fakeData($options);

            PHPUnit::assertSame($obj, $mock);

            if ($mock->getData() === null) {
                PHPUnit::assertTrue($mock->dataHasBeenSet());
                $count++;
            }
        }

        PHPUnit::assertGreaterThan(0, $count);
    }
}
