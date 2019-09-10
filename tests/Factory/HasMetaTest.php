<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\HasMeta;
use VGirol\JsonApiFaker\Testing\CheckMethods;
use VGirol\JsonApiFaker\Tests\TestCase;

class HasMetaTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function setMeta()
    {
        $this->checkSetMethod(
            $this->getMockForTrait(HasMeta::class),
            'setMeta',
            'meta',
            [
                'first' => 'test'
            ],
            [
                'second' => 'another test'
            ]
        );
    }

    /**
     * @test
     */
    public function addToMeta()
    {
        $this->checkAddSingle(
            new class extends BaseFactory {
                use HasMeta;

                public function toArray(): ?array
                {
                    return null;
                }

                public function fake()
                {
                    return $this;
                }
            },
            'addToMeta',
            'meta',
            ['first' => 'test'],
            ['second' => 'another test']
        );
    }

    /**
     * @test
     */
    public function fakeMeta()
    {
        $mock = new class extends BaseFactory {
            use HasMeta;

            public function toArray(): ?array
            {
                return null;
            }

            public function fake()
            {
                return $this;
            }
        };

        PHPUnit::assertEmpty($mock->meta);

        $obj = $mock->fakeMeta();

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->meta);
        PHPUnit::assertEquals(5, count($mock->meta));

        Assert::assertIsValidMetaObject($mock->meta, true);
    }
}
