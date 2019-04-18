<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use PHPUnit\Framework\Exception;
use VGirol\JsonApiAssert\Assert as JsonApiAssert;
use VGirol\JsonApiAssert\Messages;
use VGirol\JsonApiAssert\Tests\TestCase;

class BaseTest extends TestCase
{
    /**
     * @test
     */
    public function assertHasMember()
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
    public function assertHasMemberFailed()
    {
        $expected = 'member';
        $json = [
            'anything' => 'else'
        ];
        $failureMessage = sprintf(Messages::HAS_MEMBER, 'member');

        $this->setFailureException($failureMessage);
        JsonApiAssert::assertHasMember($expected, $json);
    }

    /**
     * @test
     * @dataProvider hasMemberInvalidArgumentsProvider
     */
    public function assertHasMemberInvalidArguments($expected, $json, $failureMsg)
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
                JsonApiAssert::getInvalidArgumentExceptionRegex(1, 'string', 666)
            ],
            '$json is not an array' => [
                'anything',
                'invalid',
                JsonApiAssert::getInvalidArgumentExceptionRegex(2, 'array', 'invalid')
            ]
        ];
    }

    /**
     * @test
     */
    public function assertHasMembers()
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
    public function assertHasMembersFailed()
    {
        $data = [
            'meta' => 'test',
            'anything' => 'else'
        ];
        $keys = ['meta', 'nothing'];
        $failureMessage = sprintf(Messages::HAS_MEMBER, 'nothing');

        $this->setFailureException($failureMessage);
        JsonApiAssert::assertHasMembers($keys, $data);
    }

    /**
     * @test
     * @dataProvider hasMembersInvalidArgumentsProvider
     */
    public function assertHasMembersWithInvalidArguments($expected, $json, $failureMsg)
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
                JsonApiAssert::getInvalidArgumentExceptionRegex(1, 'array', 'invalid')
            ],
            '$json is not an array' => [
                [
                    'anything'
                ],
                'invalid',
                JsonApiAssert::getInvalidArgumentExceptionRegex(2, 'array', 'invalid')
            ]
        ];
    }

    /**
     * @test
     */
    public function assertHasOnlyMembers()
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
    public function assertHasOnlyMembersFailed()
    {
        $data = [
            'data' => 'jsonapi',
            'meta' => 'test',
            'anything' => 'else'
        ];
        $keys = ['meta', 'data'];
        $failureMessage = sprintf(Messages::HAS_ONLY_MEMBERS, implode(', ', $keys));

        $this->setFailureException($failureMessage);
        JsonApiAssert::assertHasOnlyMembers($keys, $data);
    }

    /**
     * @test
     * @dataProvider hasOnlyMembersInvalidArgumentsProvider
     */
    public function assertHasOnlyMembersWithInvalidArguments($expected, $json, $failureMsg)
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
                JsonApiAssert::getInvalidArgumentExceptionRegex(1, 'array', 666)
            ],
            '$json is not an array' => [
                [
                    'anything'
                ],
                'invalid',
                JsonApiAssert::getInvalidArgumentExceptionRegex(2, 'array', 'invalid')
            ]
        ];
    }

    /**
     * @test
     */
    public function assertNotHasMember()
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
    public function assertNotHasMemberFailed()
    {
        $data = [
            'anything' => 'else'
        ];
        $expected = 'anything';
        $failureMessage = sprintf(Messages::NOT_HAS_MEMBER, $expected);

        $this->setFailureException($failureMessage);
        JsonApiAssert::assertNotHasMember($expected, $data);
    }

    /**
     * @test
     * @dataProvider notHasMemberInvalidArgumentsProvider
     */
    public function assertNotHasMemberWithInvalidArguments($expected, $json, $failureMsg)
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
                JsonApiAssert::getInvalidArgumentExceptionRegex(1, 'string', 666)
            ],
            '$json is not an array' => [
                'anything',
                'invalid',
                JsonApiAssert::getInvalidArgumentExceptionRegex(2, 'array', 'invalid')
            ]
        ];
    }

    /**
     * @test
     */
    public function assertNotHasMembers()
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
    public function assertNotHasMembersFailed()
    {
        $data = [
            'anything' => 'else',
            'meta' => 'test'
        ];
        $expected = [
            'anything',
            'something'
        ];
        $failureMessage = sprintf(Messages::NOT_HAS_MEMBER, 'anything');

        $this->setFailureException($failureMessage);
        JsonApiAssert::assertNotHasMembers($expected, $data);
    }

    /**
     * @test
     * @dataProvider notHasMembersInvalidArgumentsProvider
     */
    public function assertNotHasMembersWithInvalidArguments($expected, $json, $failureMsg)
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
                JsonApiAssert::getInvalidArgumentExceptionRegex(1, 'array', 666)
            ]
        ];
    }

    /**
     * @test
     */
    public function assertHasData()
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
    public function assertHasAttributes()
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
    public function assertHasLinks()
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
    public function assertHasMeta()
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
    public function assertHasIncluded()
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
    public function assertHasRelationships()
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
    public function assertHasErrors()
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
    public function assertContainsAtLeastOneMember()
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
    public function assertContainsAtLeastOneMemberFailed()
    {
        $expected = ['first', 'second'];
        $data = [
            'meta' => 'valid',
            'errors' => 'jsonapi'
        ];
        $failureMessage = sprintf(Messages::CONTAINS_AT_LEAST_ONE, implode(', ', $expected));

        $this->setFailureException($failureMessage);
        JsonApiAssert::assertContainsAtLeastOneMember($expected, $data);
    }

    /**
     * @test
     */
    public function assertContainsOnlyAllowedMembers()
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
    public function assertContainsOnlyAllowedMembersFailed()
    {
        $expected = ['first', 'second', 'meta'];
        $data = [
            'meta' => 'valid',
            'errors' => 'jsonapi'
        ];
        $failureMessage = Messages::ONLY_ALLOWED_MEMBERS;

        $this->setFailureException($failureMessage);
        JsonApiAssert::assertContainsOnlyAllowedMembers($expected, $data);
    }

    /**
     * @test
     * @dataProvider arrayOfObjectsProvider
     */
    public function assertIsArrayOfObjects($json)
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
    public function assertIsArrayOfObjectsFailed($data, $message, $failureMessage)
    {
        $this->setFailureException($failureMessage);
        JsonApiAssert::assertIsArrayOfObjects($data, $message);
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
    public function assertIsArrayOfObjectsWithInvalidArguments()
    {

        $json = 'invalid';
        $failureMsg = JsonApiAssert::getInvalidArgumentExceptionRegex(1, 'array', $json);

        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegExp($failureMsg);

        JsonApiAssert::assertIsArrayOfObjects($json);
    }

    /**
     * @test
     */
    public function assertIsNotArrayOfObjects()
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
    public function assertIsNotArrayOfObjectsFailed()
    {
        $data = [
            [
                'meta' => 'valid'
            ],
            [
                'first' => 'jsonapi'
            ]
        ];
        $failureMessage = null;

        $this->setFailureException($failureMessage);
        JsonApiAssert::assertIsNotArrayOfObjects($data);
    }
}
