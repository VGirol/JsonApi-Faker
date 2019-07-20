<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use VGirol\JsonApiAssert\Factory\BaseFactory;
use VGirol\JsonApiAssert\Factory\HasMeta;
use VGirol\JsonApiAssert\Tests\TestCase;

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
            new class extends BaseFactory
            {
                use HasMeta;

                public function toArray(): ?array
                {
                    return null;
                }
            },
            'addToMeta',
            'meta',
            ['first' => 'test'],
            ['second' => 'another test']
        );
    }
}
