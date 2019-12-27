<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiConstant\Members;
use VGirol\JsonApiFaker\Factory\JsonapiFactory;
use VGirol\JsonApiFaker\Tests\TestCase;

class JsonapiFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function toArrayEmpty()
    {
        $expected = [];

        $factory = new JsonapiFactory;

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function toArrayWithoutMeta()
    {
        $version = '1.0';
        $expected = [
            Members::JSONAPI_VERSION => $version
        ];

        $factory = new JsonapiFactory;
        $factory->setVersion($version);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function toArrayWithMeta()
    {
        $key = 'key';
        $value = 'value';
        $expected = [
            Members::META => [
                $key => $value
            ]
        ];

        $factory = new JsonapiFactory;
        $factory->addToMeta($key, $value);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function fake()
    {
        $factory = new JsonapiFactory;

        PHPUnit::assertEmpty($factory->getVersion());
        PHPUnit::assertEmpty($factory->getMeta());

        $obj = $factory->fake();

        PHPUnit::assertSame($obj, $factory);
        PHPUnit::assertNotEmpty($factory->getVersion());
        PHPUnit::assertNotEmpty($factory->getMeta());
        PHPUnit::assertCount(5, $factory->getMeta());

        Assert::assertIsValidJsonapiObject($obj->toArray(), true);
    }
}
