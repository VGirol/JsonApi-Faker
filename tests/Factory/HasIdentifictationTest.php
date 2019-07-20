<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Factory\HasIdentification;
use VGirol\JsonApiAssert\Tests\TestCase;

class HasIdentificationTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function setId()
    {
        $this->checkSetMethod(
            $this->getMockForTrait(HasIdentification::class),
            'setId',
            'id',
            'test',
            'test2'
        );
    }

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
                    'id' => 'idTest',
                    'type' => 'typeTest'
                ]
            ],
            'no id' => [
                null,
                'typeTest',
                [
                    'id' => null,
                    'type' => 'typeTest'
                ]
            ],
            'no type' => [
                'idTest',
                null,
                [
                    'id' => 'idTest',
                    'type' => null
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
}
