<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\HasLinks;
use VGirol\JsonApiFaker\Testing\CheckMethods;
use VGirol\JsonApiFaker\Tests\TestCase;

class HasLinksTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function setLinks()
    {
        $this->checkSetMethod(
            $this->getMockForTrait(HasLinks::class),
            'setLinks',
            'getLinks',
            [
                'self' => 'test'
            ],
            [
                'related' => 'another test'
            ]
        );
    }

    /**
     * @test
     */
    public function addLink()
    {
        $this->checkAddSingle(
            new class extends BaseFactory
            {
                use HasLinks;

                public function toArray(): ?array
                {
                    return null;
                }

                public function fake()
                {
                    return $this;
                }
            },
            'addLink',
            'getLinks',
            [
                'self' => 'test'
            ],
            [
                'related' => 'another test'
            ]
        );
    }

    /**
     * @test
     */
    public function addLinks()
    {
        $this->checkAddMulti(
            new class extends BaseFactory
            {
                use HasLinks;

                public function toArray(): ?array
                {
                    return null;
                }

                public function fake()
                {
                    return $this;
                }
            },
            'addLinks',
            'getLinks',
            [
                'self' => 'test',
                'related' => 'another test'
            ],
            [
                'other' => 'anything'
            ]
        );
    }

    /**
     * @test
     */
    public function fakeLinks()
    {
        $mock = new class extends BaseFactory
        {
            use HasLinks;

            public function toArray(): ?array
            {
                return null;
            }

            public function fake()
            {
                return $this;
            }
        };

        PHPUnit::assertEmpty($mock->getLinks());

        $obj = $mock->fakeLinks();

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->getLinks());
        PHPUnit::assertEquals(1, count($mock->getLinks()));
        PHPUnit::assertEquals(['self'], array_keys($mock->getLinks()));

        Assert::assertIsValidLinksObject($mock->getLinks(), ['self'], true);
    }
}
