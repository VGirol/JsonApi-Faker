<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\HasRelationships;
use VGirol\JsonApiFaker\Generator;
use VGirol\JsonApiFaker\Testing\CheckMethods;
use VGirol\JsonApiFaker\Tests\TestCase;

class HasRelationshipsTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function addRelationship()
    {
        $this->checkAddSingle(
            new class extends BaseFactory
            {
                use HasRelationships;

                public function toArray(): ?array
                {
                    return null;
                }

                public function fake()
                {
                    return $this;
                }
            },
            'addRelationship',
            'getRelationships',
            [
                'relation1' => 'value1'
            ],
            [
                'relation2' => 'value2'
            ]
        );
    }

    /**
     * @test
     */
    public function fakeRelationships()
    {
        $mock = new class extends BaseFactory
        {
            use HasRelationships;

            public function toArray(): ?array
            {
                return array_map(
                    function ($relationship) {
                        return $relationship->toArray();
                    },
                    $this->relationships
                );
            }

            public function fake()
            {
                return $this;
            }
        };

        $mock->setGenerator(new Generator);

        PHPUnit::assertEmpty($mock->getRelationships());

        $obj = $mock->fakeRelationships();

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->getRelationships());
        PHPUnit::assertEquals(2, count($mock->getRelationships()));

        Assert::assertIsValidRelationshipsObject($mock->toArray(), true);
    }
}
