<?php
namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Factory\HelperFactory;
use VGirol\JsonApiAssert\Tests\TestCase;

class JsonapiFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function jsonapiFactoryEmpty()
    {
        $expected = [];

        $factory = HelperFactory::create('jsonapi');

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function jsonapiFactoryWithoutMeta()
    {
        $version = '1.0';
        $expected = [
            'version' => $version
        ];

        $factory = HelperFactory::create('jsonapi');
        $factory->setVersion($version);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }

    /**
     * @test
     */
    public function jsonapiFactoryWithMeta()
    {
        $key = 'key';
        $value = 'value';
        $expected = [
            'meta' => [
                $key => $value
            ]
        ];

        $factory = HelperFactory::create('jsonapi');
        $factory->addToMeta($key, $value);

        $result = $factory->toArray();

        PHPUnit::assertSame($expected, $result);
    }
}
