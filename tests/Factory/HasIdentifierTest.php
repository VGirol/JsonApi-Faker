<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\HasIdentifier;
use VGirol\JsonApiFaker\Testing\CheckMethods;
use VGirol\JsonApiFaker\Tests\TestCase;

class HasIdentifierTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function setId()
    {
        $this->checkSetMethod(
            $this->getMockForTrait(HasIdentifier::class),
            'setId',
            'getId',
            'test',
            'test2'
        );
    }

    /**
     * @test
     */
    public function fakeIdentifier()
    {
        $mock = new class extends BaseFactory
        {
            use HasIdentifier;

            public function toArray(): ?array
            {
                return [
                    'id' => strval($this->id)
                ];
            }

            public function fake()
            {
                return $this;
            }
        };

        PHPUnit::assertEmpty($mock->getId());

        $obj = $mock->fakeIdentifier();

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->getId());
        PHPUnit::assertGreaterThanOrEqual(0, $mock->getId());
        PHPUnit::assertLessThanOrEqual(100, $mock->getId());

        Assert::assertResourceIdMember($obj->toArray());
    }
}
