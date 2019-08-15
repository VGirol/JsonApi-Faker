<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\HasData;
use VGirol\JsonApiFaker\Testing\CheckMethods;
use VGirol\JsonApiFaker\Tests\TestCase;

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

    /**
     * @test
     */
    public function fakeData()
    {
        $mock = new class extends BaseFactory
        {
            use HasData;

            public function toArray(): ?array
            {
                return null;
            }

            public function fake()
            {
                return $this;
            }
        };

        PHPUnit::assertEmpty($mock->data);

        $obj = $mock->fakeData();

        PHPUnit::assertSame($obj, $mock);
        // PHPUnit::assertNotEmpty('links', $mock);
        // PHPUnit::assertEquals(1, count($mock->links));
        // PHPUnit::assertEquals(['self'], array_keys($mock->links));

        // Assert::assertIsValidLinksObject($mock->links, ['self'], true);
    }
}
