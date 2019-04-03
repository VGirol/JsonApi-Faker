<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use VGirol\JsonApiAssert\Tests\TestCase;
use PHPUnit\Framework\ExpectationFailedException;
use VGirol\JsonApiAssert\Constraint\ContainsOnlyAllowedMembersConstraint;

class ContainsOnlyAllowedMembersTest extends TestCase
{
    /**
     * @test
     */
    public function assert_contains_only_allowed_members()
    {
        $allowed = ['anything', 'something'];

        $constraint = new ContainsOnlyAllowedMembersConstraint($allowed);

        $json = [
            'anything' => 'ok'
        ];
        $this->assertTrue($constraint->evaluate($json, '', true));
    }

    /**
     * @test
     * @dataProvider assertContainsOnlyAllowedMembersFailedProvider
     */
    public function assert_contains_only_allowed_members_failed($json)
    {
        $allowed = ['anything', 'something'];

        $constraint = new ContainsOnlyAllowedMembersConstraint($allowed);

        $this->assertFalse($constraint->evaluate($json, '', true));
    }

    public function assertContainsOnlyAllowedMembersFailedProvider()
    {
        return [
            'not an array' => [
                'failed'
            ],
            'not only allowed members' => [
                [
                    'anything' => 'ok',
                    'notAllowed' => 'bad'
                ]
            ]
        ];
    }

    /**
     * @test
     */
    public function assert_contains_only_allowed_members_failed_and_throw_exception()
    {
        $allowed = ['anything', 'something'];
        $json = [
            'anything' => 'ok',
            'notAllowed' => 'bad'
        ];

        $constraint = new ContainsOnlyAllowedMembersConstraint($allowed);

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
