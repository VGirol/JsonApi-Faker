<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use VGirol\JsonApiAssert\Assert as JsonApiAssert;
use VGirol\JsonApiAssert\Tests\TestCase;
use VGirol\JsonApiAssert\Messages;

class JsonapiObjectTest extends TestCase
{
    /**
     * @test
     */
    public function jsonapi_object_is_valid()
    {
        $data = [
            'version' => 'jsonapi v1.1',
            'meta' => [
                'allowed' => 'valid'
            ]
        ];
        $strict = false;

        JsonApiAssert::assertIsValidJsonapiObject($data, $strict);
    }

    /**
     * @test
     * @dataProvider notValidJsonapiObjectProvider
     */
    public function jsonapi_object_is_not_valid($data, $strict, $failureMessage)
    {
        $fn = function ($data, $strict) {
            JsonApiAssert::assertIsValidJsonapiObject($data, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data, $strict);
    }

    public function notValidJsonapiObjectProvider()
    {
        return [
            'array of objects' => [
                [
                    [
                        'version' => 'jsonapi 1.0'
                    ],
                    [
                        'not' => 'allowed'
                    ]
                ],
                false,
                Messages::OBJECT_NOT_ARRAY
            ],
            'not allowed member' => [
                [
                    'version' => 'jsonapi 1.0',
                    'not' => 'allowed'
                ],
                false,
                Messages::ONLY_ALLOWED_MEMBERS
            ],
            'version is not a string' => [
                [
                    'version' => 123
                ],
                false,
                Messages::JSONAPI_VERSION_IS_NOT_STRING
            ],
            'meta not valid' => [
                [
                    'version' => 'jsonapi 1.0',
                    'meta' => [
                        'key+' => 'not valid'
                    ]
                ],
                false,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ],
            'meta with not safe member' => [
                [
                    'version' => 'jsonapi 1.0',
                    'meta' => [
                        'not safe' => 'not valid'
                    ]
                ],
                true,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ]
        ];
    }
}
