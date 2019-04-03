<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use VGirol\JsonApiAssert\Tests\TestCase;
use PHPUnit\Framework\ExpectationFailedException;
use VGirol\JsonApiAssert\Constraint\ContainsAtLeastOneConstraint;

class ContainsAtLeastOneTest extends TestCase
{
    /**
     * @test
     */
    public function assert_contains_at_least_one()
    {
        $allowed = ['anything', 'something'];

        $constraint = new ContainsAtLeastOneConstraint($allowed);

        $json = [
            'anything' => 'ok',
            'another' => 'ok'
        ];
        $this->assertTrue($constraint->evaluate($json, '', true));
    }

    /**
     * @test
     * @dataProvider assertContainsAtLeastOneFailedProvider
     */
    public function assert_contains_at_least_one_failed($json)
    {
        $allowed = ['anything', 'something'];

        $constraint = new ContainsAtLeastOneConstraint($allowed);

        $this->assertFalse($constraint->evaluate($json, '', true));
    }

    public function assertContainsAtLeastOneFailedProvider()
    {
        return [
            'not an array' => [
                'failed'
            ],
            'no one expected member' => [
                [
                    'unexpected' => 'bad'
                ]
            ]
        ];
    }

    /**
     * @test
     */
    public function assert_contains_at_least_one_failed_and_throw_exception()
    {
        $allowed = ['anything', 'something'];
        $json = [
            'unexpected' => 'bad'
        ];

        $constraint = new ContainsAtLeastOneConstraint($allowed);

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessageRegExp(
            sprintf(
                '/Failed asserting that [\S\s]* %s\./',
                $constraint->toString()
            )
        );

        $constraint->evaluate($json);
    }
}
