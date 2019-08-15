<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\HasAttributes;
use VGirol\JsonApiFaker\Testing\CheckMethods;
use VGirol\JsonApiFaker\Tests\TestCase;

class HasAttributesTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function setAttributes()
    {
        $this->checkSetMethod(
            $this->getMockForTrait(HasAttributes::class),
            'setAttributes',
            'attributes',
            [
                'attr1' => 'value1'
            ],
            [
                'attr2' => 'value2'
            ]
        );
    }

    /**
     * @test
     */
    public function addAttribute()
    {
        $this->checkAddSingle(
            new class extends BaseFactory
            {
                use HasAttributes;

                public function toArray(): ?array
                {
                    return null;
                }

                public function fake()
                {
                    return $this;
                }
            },
            'addAttribute',
            'attributes',
            [
                'attr1' => 'value1'
            ],
            [
                'attr2' => 'value2'
            ]
        );
    }

    /**
     * @test
     */
    public function addAttributes()
    {
        $this->checkAddMulti(
            new class extends BaseFactory
            {
                use HasAttributes;

                public function toArray(): ?array
                {
                    return null;
                }

                public function fake()
                {
                    return $this;
                }
            },
            'addAttributes',
            'attributes',
            [
                'attr1' => 'value1',
                'attr2' => 'value2'
            ],
            [
                'attr3' => 'value3',
                'attr4' => 'value4'
            ]
        );
    }

    /**
     * @test
     */
    public function fakeAttributes()
    {
        $mock = new class extends BaseFactory
        {
            use HasAttributes;

            public function toArray(): ?array
            {
                return null;
            }

            public function fake()
            {
                return $this;
            }
        };

        PHPUnit::assertEmpty($mock->attributes);

        $obj = $mock->fakeAttributes();

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->attributes);
        PHPUnit::assertEquals(5, count($mock->attributes));

        Assert::assertIsValidAttributesObject($mock->attributes, true);
    }
}
