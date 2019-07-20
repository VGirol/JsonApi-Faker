<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use VGirol\JsonApiAssert\Factory\HasResourceType;
use VGirol\JsonApiAssert\Tests\TestCase;

class HasResourceTypeTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function setResourceType()
    {
        $this->checkSetMethod(
            $this->getMockForTrait(HasResourceType::class),
            'setResourceType',
            'resourceType',
            'first',
            'second'
        );
    }
}
