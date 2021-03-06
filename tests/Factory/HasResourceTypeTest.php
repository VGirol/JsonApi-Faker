<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiConstant\Members;
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
            'getResourceType',
            'val1',
            'val2'
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
                    Members::TYPE => $this->resourceType
                ];
            }

            public function fake()
            {
                return $this;
            }
        };

        PHPUnit::assertEmpty($mock->getResourceType());

        $obj = $mock->fakeResourceType();

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->getResourceType());

        Assert::assertResourceTypeMember($obj->toArray(), true);
    }
}
