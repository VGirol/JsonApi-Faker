<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use VGirol\JsonApiAssert\Factory\HasData;
use VGirol\JsonApiAssert\Tests\TestCase;

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
}
