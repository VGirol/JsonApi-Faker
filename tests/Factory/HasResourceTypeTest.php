<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\HasResourceType;
use VGirol\JsonApiFaker\Testing\CheckMethods;
use VGirol\JsonApiFaker\Tests\TestCase;

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

    /**
     * @test
     */
    public function fakeResourceType()
    {
        $mock = new class extends BaseFactory {
            use HasResourceType;

            public function toArray(): ?array
            {
                return [
                    'type' => $this->resourceType
                ];
            }

            public function fake()
            {
                return $this;
            }
        };

        PHPUnit::assertEmpty($mock->resourceType);

        $obj = $mock->fakeResourceType();

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->resourceType);

        Assert::assertResourceTypeMember($obj->toArray(), true);
    }
}
