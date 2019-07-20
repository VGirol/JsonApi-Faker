<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use VGirol\JsonApiAssert\Factory\BaseFactory;
use VGirol\JsonApiAssert\Factory\HasLinks;
use VGirol\JsonApiAssert\Tests\TestCase;

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
            'links',
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
            },
            'addLink',
            'links',
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
            },
            'addLinks',
            'links',
            [
                'self' => 'test',
                'related' => 'another test'
            ],
            [
                'other' => 'anything'
            ]
        );
    }
}
