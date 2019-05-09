<?php
namespace VGirol\JsonApiAssert\Tests\Asserts\Structure;

use VGirol\JsonApiAssert\Assert as JsonApiAssert;
use VGirol\JsonApiAssert\Messages;
use VGirol\JsonApiAssert\Tests\TestCase;

class AttributesObjectTest extends TestCase
{
    /**
     * @test
     */
    public function memberNameIsNotForbidden()
    {
        $name = 'valid';
        JsonApiAssert::assertIsNotForbiddenMemberName($name);
    }

    /**
     * @test
     * @dataProvider forbiddenMemberNameProvider
     */
    public function memberNameIsForbidden($data, $failureMessage)
    {
            $this->setFailureException($failureMessage);
            JsonApiAssert::assertIsNotForbiddenMemberName($data);
    }

    public function forbiddenMemberNameProvider()
    {
        return [
            'relationships' => [
                'relationships',
                Messages::MEMBER_NAME_NOT_ALLOWED
            ],
            'links' => [
                'links',
                Messages::MEMBER_NAME_NOT_ALLOWED
            ]
        ];
    }

    /**
     * @test
     */
    public function assertIsNotForbiddenMemberNameWithInvalidArguments()
    {
        $data = 666;

        $this->setInvalidArgumentException(1, 'string', $data);

        JsonApiAssert::assertIsNotForbiddenMemberName($data);
    }

    /**
     * @test
     */
    public function fieldHasNoForbiddenMemberName()
    {
        $field = [
            'field' => 'valid'
        ];

        JsonApiAssert::assertFieldHasNoForbiddenMemberName($field);
    }

    /**
     * @test
     * @dataProvider fieldHasForbiddenMemberNameProvider
     */
    public function fieldHasForbiddenMemberName($data, $failureMessage)
    {
        $this->setFailureException($failureMessage);
        JsonApiAssert::assertFieldHasNoForbiddenMemberName($data);
    }

    public function fieldHasForbiddenMemberNameProvider()
    {
        return [
            'direct member' => [
                [
                    'anything' => 'ok',
                    'links' => 'forbidden'
                ],
                Messages::MEMBER_NAME_NOT_ALLOWED
            ],
            'nested member' => [
                [
                    'anything' => 'ok',
                    'something' => [
                        'links' => 'forbidden'
                    ]
                ],
                Messages::MEMBER_NAME_NOT_ALLOWED
            ]
        ];
    }

    /**
     * @test
     * @dataProvider validAttributesObjectProvider
     */
    public function attributesObjectIsValid($json, $strict)
    {
        JsonApiAssert::assertIsValidAttributesObject($json, $strict);
    }

    public function validAttributesObjectProvider()
    {
        return [
            'strict' => [
                [
                    'strict' => 'value'
                ],
                true
            ],
            'not strict' => [
                [
                    'not strict' => 'value'
                ],
                false
            ]
        ];
    }

    /**
     * @test
     * @dataProvider notValidAttributesObjectProvider
     */
    public function attributesObjectIsNotValid($json, $strict, $failureMessage)
    {
        $this->setFailureException($failureMessage);
        JsonApiAssert::assertIsValidAttributesObject($json, $strict);
    }

    public function notValidAttributesObjectProvider()
    {
        return [
            'key is not valid' => [
                [
                    'key+' => 'value'
                ],
                false,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ],
            'key is not safe' => [
                [
                    'not safe' => 'value'
                ],
                true,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ],
            'field has forbidden member' => [
                [
                    'key' => [
                        'obj' => 'value',
                        'links' => 'forbidden'
                    ]
                ],
                false,
                Messages::MEMBER_NAME_NOT_ALLOWED
            ]
        ];
    }

    /**
     * @test
     */
    public function assertIsValidAttributesObjectWithInvalidArguments()
    {
        $attributes = 'failed';
        $strict = false;

        $this->setInvalidArgumentException(1, 'array', $attributes);

        JsonApiAssert::assertIsValidAttributesObject($attributes, $strict);
    }
}