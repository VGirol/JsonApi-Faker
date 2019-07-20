<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Factory\BaseFactory;
use VGirol\JsonApiAssert\Factory\HasErrors;
use VGirol\JsonApiAssert\Tests\TestCase;

class HasErrorsTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function setErrors()
    {
        $this->checkSetMethod(
            $this->getMockForTrait(HasErrors::class),
            'setErrors',
            'errors',
            [
                'test'
            ],
            [
                'another test'
            ]
        );
    }

    /**
     * @test
     */
    public function addError()
    {
        $errors = [
            'test'
        ];
        $errors2 = 'another test';

        $factory = new class extends BaseFactory
        {
            use HasErrors;

            public function toArray(): ?array
            {
                return null;
            }
        };

        PHPUnit::assertEmpty($factory->errors);

        $factory->setErrors($errors);

        PHPUnit::assertObjectHasAttribute('errors', $factory);
        PHPUnit::assertEquals($errors, $factory->errors);

        $obj = $factory->addError($errors2);

        PHPUnit::assertEquals(
            array_merge($errors, [$errors2]),
            $factory->errors
        );
        PHPUnit::assertSame($obj, $factory);
    }
}
