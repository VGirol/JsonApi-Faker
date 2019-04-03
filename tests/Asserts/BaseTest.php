<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use PHPUnit\Framework\Exception;
use VGirol\JsonApiAssert\Messages;
use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Tests\TestCase;
use PHPUnit\Framework\ExpectationFailedException;
use VGirol\JsonApiAssert\Assert as JsonApiAssert;

class BaseTest extends TestCase
{
    /**
     * @test
     */
    public function assert_test_failed_with_success()
    {
        $failureMsg = 'Try again !';
        $fn = function() use ($failureMsg) {
            PHPUnit::assertTrue(false, $failureMsg);
        };

        JsonApiAssert::assertTestFail($fn, $failureMsg);
    }

    /**
     * @test
     */
    public function assert_test_failed_with_error()
    {
        $failureMsg = 'Try again !';
        $fn = function() {
            PHPUnit::assertTrue(false);
        };

        $this->expectException(Exception::class);

        JsonApiAssert::assertTestFail($fn, $failureMsg);
    }

    /**
     * @test
     */
    public function assert_test_failed_but_doesnt_failed()
    {
        $failureMsg = 'Try again !';
        $fn = function() use ($failureMsg) {
            PHPUnit::assertTrue(true, $failureMsg);
        };

        $this->expectException(ExpectationFailedException::class);
        $this->expectExceptionMessage(Messages::TEST_FAILED);

        JsonApiAssert::assertTestFail($fn, $failureMsg);
    }

    /**
     * @test
     */
    public function assert_has_member()
    {
        $json = [
            'data' => 'jsonapi',
            'meta' => 'valid'
        ];
        $expected = 'data';

        JsonApiAssert::assertHasMember($expected, $json);
    }

    /**
     * @test
     */
    public function assert_has_member_failed()
    {
        $expected = 'member';
        $json = [
            'anything' => 'else'
        ];
        $failureMsg = sprintf(Messages::HAS_MEMBER, 'member');

        $fn = function ($expected, $json) {
            JsonApiAssert::assertHasMember($expected, $json);
        };

        JsonApiAssert::assertTestFail($fn, $failureMsg, $expected, $json);
    }

    /**
     * @test
     * @dataProvider hasMemberInvalidArgumentsProvider
     */
    public function assert_has_member_invalid_arguments($expected, $json, $failureMsg)
    {
        $this->expectException(Exception::class);
        if (!is_null($failureMsg)) {
            $this->expectExceptionMessageRegExp($failureMsg);
        }

        JsonApiAssert::assertHasMember($expected, $json);
    }

    public function hasMemberInvalidArgumentsProvider()
    {
        return [
            '$expected is not a string' => [
                666,
                [
                    'anything' => 'else'
                ],
                $this->getPhpunitExceptionText(1, 'string', 666)
            ],
            '$json is not an array' => [
                'anything',
                'invalid',
                $this->getPhpunitExceptionText(2, 'array', 'invalid')
            ]
        ];
    }

    /**
     * @test
     */
    public function assert_has_members()
    {
        $data = [
            'data' => 'jsonapi',
            'meta' => 'valid',
            'jsonapi' =>'ok'
        ];
        $expected = ['data', 'meta'];

        JsonApiAssert::assertHasMembers($expected, $data);
    }

    /**
     * @test
     */
    public function assert_has_members_failed()
    {
        $data = [
            'meta' => 'test',
            'anything' => 'else'
        ];
        $keys = ['meta', 'nothing'];
        $failureMsg = sprintf(Messages::HAS_MEMBER, 'nothing');

        $fn = function ($data, $keys) {
            JsonApiAssert::assertHasMembers($keys, $data);
        };

        JsonApiAssert::assertTestFail($fn, $failureMsg, $data, $keys);
    }

    /**
     * @test
     * @dataProvider hasMembersInvalidArgumentsProvider
     */
    public function assert_has_members_invalid_arguments($expected, $json, $failureMsg)
    {
        $this->expectException(Exception::class);
        if (!is_null($failureMsg)) {
            $this->expectExceptionMessageRegExp($failureMsg);
        }

        JsonApiAssert::assertHasMembers($expected, $json);
    }

    public function hasMembersInvalidArgumentsProvider()
    {
        return [
            '$expected is not an array' => [
                'invalid',
                [
                    'anything' => 'else'
                ],
                $this->getPhpunitExceptionText(1, 'array', 'invalid')
            ],
            '$json is not an array' => [
                [
                    'anything'
                ],
                'invalid',
                $this->getPhpunitExceptionText(2, 'array', 'invalid')
            ]
        ];
    }

    /**
     * @test
     */
    public function assert_has_only_members()
    {
        $data = [
            'data' => 'jsonapi',
            'meta' => 'valid'
        ];
        $expected = ['data', 'meta'];

        JsonApiAssert::assertHasOnlyMembers($expected, $data);
    }

    /**
     * @test
     */
    public function assert_has_only_members_failed()
    {
        $data = [
            'data' => 'jsonapi',
            'meta' => 'test',
            'anything' => 'else'
        ];
        $keys = ['meta', 'data'];
        $failureMsg = sprintf(Messages::HAS_ONLY_MEMBERS, implode(', ', $keys));

        $fn = function ($data, $keys) {
            JsonApiAssert::assertHasOnlyMembers($keys, $data);
        };

        JsonApiAssert::assertTestFail($fn, $failureMsg, $data, $keys);
    }

    /**
     * @test
     * @dataProvider hasOnlyMembersInvalidArgumentsProvider
     */
    public function assert_has_only_members_invalid_arguments($expected, $json, $failureMsg)
    {
        $this->expectException(Exception::class);
        if (!is_null($failureMsg)) {
            $this->expectExceptionMessageRegExp($failureMsg);
        }

        JsonApiAssert::assertHasOnlyMembers($expected, $json);
    }

    public function hasOnlyMembersInvalidArgumentsProvider()
    {
        return [
            '$expected is not an array' => [
                666,
                [
                    'anything' => 'else'
                ],
                $this->getPhpunitExceptionText(1, 'array', 666)
            ],
            '$json is not an array' => [
                [
                    'anything'
                ],
                'invalid',
                $this->getPhpunitExceptionText(2, 'array', 'invalid')
            ]
        ];
    }

    /**
     * @test
     */
    public function assert_not_has_member()
    {
        $data = [
            'data' => 'jsonapi',
            'meta' => 'valid'
        ];
        $expected = 'test';

        JsonApiAssert::assertNotHasMember($expected, $data);
    }

    /**
     * @test
     */
    public function assert_not_has_member_failed()
    {
        $data = [
            'anything' => 'else'
        ];
        $expected = 'anything';

        $fn = function ($data, $expected) {
            JsonApiAssert::assertNotHasMember($expected, $data);
        };

        JsonApiAssert::assertTestFail(
            $fn,
            sprintf(Messages::NOT_HAS_MEMBER, $expected),
            $data,
            $expected
        );
    }

    /**
     * @test
     * @dataProvider notHasMemberInvalidArgumentsProvider
     */
    public function assert_not_has_member_invalid_arguments($expected, $json, $failureMsg)
    {
        $this->expectException(Exception::class);
        if (!is_null($failureMsg)) {
            $this->expectExceptionMessageRegExp($failureMsg);
        }

        JsonApiAssert::assertNotHasMember($expected, $json);
    }

    public function notHasMemberInvalidArgumentsProvider()
    {
        return [
            '$expected is not a string' => [
                666,
                [
                    'anything' => 'else'
                ],
                $this->getPhpunitExceptionText(1, 'string', 666)
            ],
            '$json is not an array' => [
                'anything',
                'invalid',
                $this->getPhpunitExceptionText(2, 'array', 'invalid')
            ]
        ];
    }

    /**
     * @test
     */
    public function assert_not_has_members()
    {
        $data = [
            'data' => 'jsonapi',
            'meta' => 'valid'
        ];
        $expected = [
            'test',
            'something'
        ];

        JsonApiAssert::assertNotHasMembers($expected, $data);
    }

    /**
     * @test
     */
    public function assert_not_has_members_failed()
    {
        $data = [
            'anything' => 'else',
            'meta' => 'test'
        ];
        $expected = [
            'anything',
            'something'
        ];

        $fn = function ($data, $expected) {
            JsonApiAssert::assertNotHasMembers($expected, $data);
        };

        JsonApiAssert::assertTestFail(
            $fn,
            sprintf(Messages::NOT_HAS_MEMBER, 'anything'),
            $data,
            $expected
        );
    }

    /**
     * @test
     * @dataProvider notHasMembersInvalidArgumentsProvider
     */
    public function assert_not_has_members_invalid_arguments($expected, $json, $failureMsg)
    {
        $this->expectException(Exception::class);
        if (!is_null($failureMsg)) {
            $this->expectExceptionMessageRegExp($failureMsg);
        }

        JsonApiAssert::assertNotHasMembers($expected, $json);
    }

    public function notHasMembersInvalidArgumentsProvider()
    {
        return [
            '$expected is not an array' => [
                666,
                [
                    'anything' => 'else'
                ],
                $this->getPhpunitExceptionText(1, 'array', 666)
            ]
        ];
    }

    /**
     * @test
     */
    public function assert_has_data()
    {
        $data = [
            'meta' => 'valid',
            'data' => 'jsonapi'
        ];

        JsonApiAssert::assertHasData($data);
    }

    /**
     * @test
     */
    public function assert_has_attributes()
    {
        $data = [
            'meta' => 'valid',
            'attributes' => 'jsonapi'
        ];

        JsonApiAssert::assertHasAttributes($data);
    }

    /**
     * @test
     */
    public function assert_has_links()
    {
        $data = [
            'meta' => 'valid',
            'links' => 'jsonapi'
        ];

        JsonApiAssert::assertHasLinks($data);
    }

    /**
     * @test
     */
    public function assert_has_meta()
    {
        $data = [
            'meta' => 'valid',
            'links' => 'jsonapi'
        ];

        JsonApiAssert::assertHasMeta($data);
    }

    /**
     * @test
     */
    public function assert_has_included()
    {
        $data = [
            'meta' => 'valid',
            'included' => 'jsonapi'
        ];

        JsonApiAssert::assertHasIncluded($data);
    }

    /**
     * @test
     */
    public function assert_has_relationships()
    {
        $data = [
            'meta' => 'valid',
            'relationships' => 'jsonapi'
        ];

        JsonApiAssert::assertHasRelationships($data);
    }

    /**
     * @test
     */
    public function assert_has_errors()
    {
        $data = [
            'meta' => 'valid',
            'errors' => 'jsonapi'
        ];

        JsonApiAssert::assertHasErrors($data);
    }

    /**
     * @test
     */
    public function assert_contains_at_least_one_member()
    {
        $expected = ['first', 'second', 'meta'];
        $data = [
            'meta' => 'valid',
            'errors' => 'jsonapi'
        ];

        JsonApiAssert::assertContainsAtLeastOneMember($expected, $data);
    }

    /**
     * @test
     */
    public function assert_contains_at_least_one_member_failed()
    {
        $expected = ['first', 'second'];
        $data = [
            'meta' => 'valid',
            'errors' => 'jsonapi'
        ];

        $fn = function ($expected, $data) {
            JsonApiAssert::assertContainsAtLeastOneMember($expected, $data);
        };

        JsonApiAssert::assertTestFail(
            $fn,
            sprintf(Messages::CONTAINS_AT_LEAST_ONE, implode(', ', $expected)),
            $expected,
            $data
        );
    }

    /**
     * @test
     */
    public function assert_contains_only_allowed_members()
    {
        $expected = ['first', 'second', 'meta'];
        $data = [
            'meta' => 'valid',
            'first' => 'jsonapi'
        ];

        JsonApiAssert::assertContainsOnlyAllowedMembers($expected, $data);
    }

    /**
     * @test
     */
    public function assert_contains_only_allowed_members_failed()
    {
        $expected = ['first', 'second', 'meta'];
        $data = [
            'meta' => 'valid',
            'errors' => 'jsonapi'
        ];

        $fn = function ($expected, $data) {
            JsonApiAssert::assertContainsOnlyAllowedMembers($expected, $data);
        };

        JsonApiAssert::assertTestFail(
            $fn,
            Messages::ONLY_ALLOWED_MEMBERS,
            $expected,
            $data
        );
    }

    /**
     * @test
     * @dataProvider arrayOfObjectsProvider
     */
    public function assert_is_array_of_objects($json)
    {
        JsonApiAssert::assertIsArrayOfObjects($json);
    }

    public function arrayOfObjectsProvider()
    {
        return [
            'empty array' => [
                []
            ],
            'filled array' => [
                [
                    [
                        'meta' => 'valid'
                    ],
                    [
                        'first' => 'jsonapi'
                    ]
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider notArrayOfObjectsProvider
     */
    public function assert_is_array_of_objects_failed($data, $message, $failureMessage)
    {
        $fn = function ($data, $message) {
            JsonApiAssert::assertIsArrayOfObjects($data, $message);
        };

        JsonApiAssert::assertTestFail(
            $fn,
            $failureMessage,
            $data,
            $message
        );
    }

    public function notArrayOfObjectsProvider()
    {
        return [
            'associative array' => [
                [
                    'meta' => 'valid',
                    'errors' => 'jsonapi'
                ],
                null,
                Messages::MUST_BE_ARRAY_OF_OBJECTS
            ],
            'customized message' => [
                [
                    'meta' => 'valid',
                    'errors' => 'jsonapi'
                ],
                'customized message',
                'customized message'
            ]
        ];
    }

    /**
     * @test
     */
    public function assert_is_array_of_objects_invalid_arguments()
    {

        $json = 'invalid';
        $failureMsg = $this->getPhpunitExceptionText(1, 'array', $json);

        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegExp($failureMsg);

        JsonApiAssert::assertIsArrayOfObjects($json);
    }

    /**
     * @test
     */
    public function assert_is_not_array_of_objects()
    {
        $data = [
            'meta' => 'valid',
            'first' => 'jsonapi'
        ];

        JsonApiAssert::assertIsNotArrayOfObjects($data);
    }

    /**
     * @test
     */
    public function assert_is_not_array_of_objects_failed()
    {
        $data = [
            [
                'meta' => 'valid'
            ],
            [
                'first' => 'jsonapi'
            ]
        ];

        $fn = function ($data) {
            JsonApiAssert::assertIsNotArrayOfObjects($data);
        };

        JsonApiAssert::assertTestFail(
            $fn,
            null,
            $data
        );
    }
}
