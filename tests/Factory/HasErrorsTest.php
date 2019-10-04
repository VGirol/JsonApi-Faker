<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;
use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\ErrorFactory;
use VGirol\JsonApiFaker\Factory\HasErrors;
use VGirol\JsonApiFaker\Generator;
use VGirol\JsonApiFaker\Messages;
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
            'getErrors',
            [
                (new Generator)->error()->fake()
            ],
            [
                (new Generator)->error()->fake()
            ]
        );
    }

    /**
     * @test
     */
    public function setErrorsFailed()
    {
        $mock = $this->getMockForTrait(HasErrors::class);

        $this->expectException(JsonApiFakerException::class);
        $this->expectExceptionMessage(Messages::SET_ERRORS_BAD_TYPE);

        $mock->setErrors(['error']);
    }

    /**
     * @test
     */
    public function addError()
    {
        $errors = [
            (new Generator)->error()->fake()
        ];
        $errors2 = (new Generator)->error()->fake();

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

        PHPUnit::assertEmpty($factory->getErrors());

        $factory->setErrors($errors);

        PHPUnit::assertEquals($errors, $factory->getErrors());

        $obj = $factory->addError($errors2);

        PHPUnit::assertEquals(
            array_merge($errors, [$errors2]),
            $factory->getErrors()
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

        $mock->setGenerator(new Generator);

        PHPUnit::assertEmpty($mock->getErrors());

        $obj = $mock->fakeErrors();

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->getErrors());
        PHPUnit::assertEquals(2, count($mock->getErrors()));

        foreach ($mock->getErrors() as $error) {
            PHPUnit::assertInstanceOf(ErrorFactory::class, $error);
            Assert::assertIsValidErrorObject($error->toArray(), true);
        }
    }
}
