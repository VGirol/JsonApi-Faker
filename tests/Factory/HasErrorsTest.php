<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\ErrorFactory;
use VGirol\JsonApiFaker\Factory\HasErrors;
use VGirol\JsonApiFaker\Testing\CheckMethods;
use VGirol\JsonApiFaker\Tests\TestCase;

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

        $factory = new class extends BaseFactory {
            use HasErrors;

            public function toArray(): ?array
            {
                return null;
            }

            public function fake()
            {
                return $this;
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

    /**
     * @test
     */
    public function fakeErrors()
    {
        $mock = new class extends BaseFactory {
            use HasErrors;

            public function toArray(): ?array
            {
                return null;
            }

            public function fake()
            {
                return $this;
            }
        };

        PHPUnit::assertEmpty($mock->errors);

        $obj = $mock->fakeErrors();

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->errors);
        PHPUnit::assertEquals(2, count($mock->errors));

        foreach ($mock->errors as $error) {
            PHPUnit::assertInstanceOf(ErrorFactory::class, $error);
            Assert::assertIsValidErrorObject($error->toArray(), true);
        }
    }
}
