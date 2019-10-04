<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\HasJsonapi;
use VGirol\JsonApiFaker\Factory\JsonapiFactory;
use VGirol\JsonApiFaker\Generator;
use VGirol\JsonApiFaker\Testing\CheckMethods;
use VGirol\JsonApiFaker\Tests\TestCase;

class HasJsonapiTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function setJsonapi()
    {
        $this->checkSetMethod(
            $this->getMockForTrait(HasJsonapi::class),
            'setJsonapi',
            'getJsonapi',
            (new Generator)->jsonapiObject()->fake(),
            (new Generator)->jsonapiObject()->fake()
        );
    }

    /**
     * @test
     */
    public function fakeJsonapi()
    {
        $mock = new class extends BaseFactory {
            use HasJsonapi;

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

        PHPUnit::assertEmpty($mock->getJsonapi());

        $obj = $mock->fakeJsonapi();

        PHPUnit::assertSame($obj, $mock);

        PHPUnit::assertInstanceOf(JsonapiFactory::class, $mock->getJsonapi());

        $meta = $mock->getJsonapi()->getMeta();
        PHPUnit::assertCount(5, $meta);
    }
}
