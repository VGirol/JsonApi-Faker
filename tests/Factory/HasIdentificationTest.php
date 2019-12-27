<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiConstant\Members;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\HasIdentification;
use VGirol\JsonApiFaker\Tests\TestCase;

class HasIdentificationTest extends TestCase
{
    /**
     * @test
     * @dataProvider getIdentificationProvider
     */
    public function getIdentification($id, $type, $expected)
    {
        $factory = $this->getMockForTrait(HasIdentification::class);
        $factory->setId($id);
        $factory->setResourceType($type);

        $result = $factory->getIdentification();

        PHPUnit::assertIsArray($result);
        PHPUnit::assertEquals($expected, $result);
    }

    public function getIdentificationProvider()
    {
        return [
            'complete' => [
                'idTest',
                'typeTest',
                [
                    Members::ID => 'idTest',
                    Members::TYPE => 'typeTest'
                ]
            ],
            'no id' => [
                null,
                'typeTest',
                [
                    Members::ID => null,
                    Members::TYPE => 'typeTest'
                ]
            ],
            'no type' => [
                'idTest',
                null,
                [
                    Members::ID => 'idTest',
                    Members::TYPE => null
                ]
            ]
        ];
    }

    /**
     * @test
     */
    public function getIdentificationReturnsNull()
    {
        $factory = $this->getMockForTrait(HasIdentification::class);
        $factory->setId(null);
        $factory->setResourceType(null);

        $result = $factory->getIdentification();

        PHPUnit::assertNull($result);
    }

    /**
     * @test
     */
    public function fakeIdentification()
    {
        $mock = new class extends BaseFactory {
            use HasIdentification;

            public function toArray(): ?array
            {
                return [
                    Members::ID => strval($this->id),
                    Members::TYPE => $this->resourceType
                ];
            }

            public function fake()
            {
                return $this;
            }
        };

        PHPUnit::assertEmpty($mock->getResourceType());
        PHPUnit::assertEmpty($mock->getId());

        $obj = $mock->fakeIdentification();

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->getResourceType());
        PHPUnit::assertNotEmpty($mock->getId());
        PHPUnit::assertGreaterThanOrEqual(0, $mock->getId());
        PHPUnit::assertLessThanOrEqual(100, $mock->getId());

        Assert::assertResourceTypeMember($obj->toArray(), true);
        Assert::assertResourceIdMember($obj->toArray());
    }
}
