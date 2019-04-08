<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use VGirol\JsonApiAssert\Assert as JsonApiAssert;
use VGirol\JsonApiAssert\Messages;
use VGirol\JsonApiAssert\Tests\TestCase;

class ErrorsObjectTest extends TestCase
{
    /**
     * @test
     */
    public function errorLinksObjectIsValid()
    {
        $links = [
            'about' => 'url'
        ];
        $strict = false;

        JsonApiAssert::assertIsValidErrorLinksObject($links, $strict);
    }

    /**
     * @test
     * @dataProvider notValidErrorLinksObjectProvider
     */
    public function errorLinksObjectIsNotValid($json, $strict, $failureMessage)
    {
        $fn = function ($json, $strict) {
            JsonApiAssert::assertIsValidErrorLinksObject($json, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $json, $strict);
    }

    public function notValidErrorLinksObjectProvider()
    {
        return [
            'not allowed member' => [
                [
                    'anything' => 'not allowed'
                ],
                false,
                Messages::ONLY_ALLOWED_MEMBERS
            ]
        ];
    }

    /**
     * @test
     * @dataProvider validErrorSourceObjectProvider
     */
    public function errorSourceObjectIsValid($data)
    {
        JsonApiAssert::assertIsValidErrorSourceObject($data);
    }

    public function validErrorSourceObjectProvider()
    {
        return [
            'short' => [
                [
                    'anything' => 'blabla'
                ]
            ],
            'long' => [
                [
                    'anything' => 'blabla',
                    'pointer' => '/data/attributes/title',
                    'parameter' => 'blabla'
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider notValidErrorSourceObjectProvider
     */
    public function errorSourceObjectIsNotValid($data, $failureMessage)
    {
        $fn = function ($data) {
            JsonApiAssert::assertIsValidErrorSourceObject($data);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data);
    }

    public function notValidErrorSourceObjectProvider()
    {
        return [
            'not an array' => [
                'error',
                Messages::ERROR_SOURCE_OBJECT_NOT_ARRAY
            ],
            'pointer is not a string' => [
                [
                    'valid' => 'valid',
                    'pointer' => 666
                ],
                Messages::ERROR_SOURCE_POINTER_IS_NOT_STRING
            ],
            'pointer does not start with a /' => [
                [
                    'valid' => 'valid',
                    'pointer' => 'not valid'
                ],
                Messages::ERROR_SOURCE_POINTER_START
            ],
            'parameter is not a string' => [
                [
                    'valid' => 'valid',
                    'parameter' => 666
                ],
                Messages::ERROR_SOURCE_PARAMETER_IS_NOT_STRING
            ]
        ];
    }

    /**
     * @test
     */
    public function errorObjectIsValid()
    {
        $data = [
            'id' => 15,
            'links' => [
                'about' => 'url'
            ],
            'status' => 'test',
            'code' => 'E13',
            'title' => 'test',
            'details' => 'test',
            'source' => [
                'anything' => 'valid',
                'pointer' => '/data/type'
            ],
            'meta' => [
                'is valid' => 'because $strict is false'
            ]
        ];
        $strict = false;

        JsonApiAssert::assertIsValidErrorObject($data, $strict);
    }

    /**
     * @test
     * @dataProvider notValidErrorObjectProvider
     */
    public function errorObjectIsNotValid($data, $strict, $failureMessage)
    {
        $fn = function ($data, $strict) {
            JsonApiAssert::assertIsValidErrorObject($data, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data, $strict);
    }

    public function notValidErrorObjectProvider()
    {
        return [
            'not an array' => [
                'error',
                false,
                Messages::ERROR_OBJECT_NOT_ARRAY
            ],
            'empty array' => [
                [],
                false,
                Messages::ERROR_OBJECT_NOT_EMPTY
            ],
            'not allowed member' => [
                [
                    'code' => 'E13',
                    'not' => 'not valid',
                ],
                false,
                Messages::ONLY_ALLOWED_MEMBERS
            ],
            'status is not a string' => [
                [
                    'code' => 'E13',
                    'status' => 666,
                ],
                false,
                Messages::ERROR_STATUS_IS_NOT_STRING
            ],
            'code is not a string' => [
                [
                    'code' => 13,
                    'status' => 'ok',
                ],
                false,
                Messages::ERROR_CODE_IS_NOT_STRING
            ],
            'title is not a string' => [
                [
                    'title' => 13,
                    'status' => 'ok',
                ],
                false,
                Messages::ERROR_TITLE_IS_NOT_STRING
            ],
            'details is not a string' => [
                [
                    'details' => 13,
                    'status' => 'ok',
                ],
                false,
                Messages::ERROR_DETAILS_IS_NOT_STRING
            ],
            'source is not an array' => [
                [
                    'status' => 'ok',
                    'source' => 'not valid'
                ],
                false,
                Messages::ERROR_SOURCE_OBJECT_NOT_ARRAY
            ],
            'source pointer is not a string' => [
                [
                    'status' => 'ok',
                    'source' => [
                        'pointer' => 666
                    ]
                ],
                false,
                Messages::ERROR_SOURCE_POINTER_IS_NOT_STRING
            ],
            'source pointer is not valid' => [
                [
                    'status' => 'ok',
                    'source' => [
                        'pointer' => 'not valid'
                    ]
                ],
                false,
                Messages::ERROR_SOURCE_POINTER_START
            ],
            'source parameter is not a string' => [
                [
                    'status' => 'ok',
                    'source' => [
                        'parameter' => 666
                    ]
                ],
                false,
                Messages::ERROR_SOURCE_PARAMETER_IS_NOT_STRING
            ],
            'links is not valid' => [
                [
                    'status' => 'ok',
                    'links' => [
                        'no' => 'not valid'
                    ]
                ],
                false,
                Messages::ONLY_ALLOWED_MEMBERS
            ],
            'meta is not valid' => [
                [
                    'status' => 'ok',
                    'meta' => [
                        'not+' => 'not valid'
                    ]
                ],
                false,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ]
        ];
    }

    /**
     * @test
     */
    public function errorsObjectIsValid()
    {
        $data = [
            [
                'status' => 'test',
                'code' => 'E13',
            ],
            [
                'status' => 'test2',
                'code' => 'E132',
            ]
        ];
        $strict = false;

        JsonApiAssert::assertIsValidErrorsObject($data, $strict);
    }

    /**
     * @test
     * @dataProvider notValidErrorsObjectProvider
     */
    public function errorsObjectIsNotValid($data, $strict, $failureMessage)
    {
        $fn = function ($data, $strict) {
            JsonApiAssert::assertIsValidErrorsObject($data, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data, $strict);
    }

    public function notValidErrorsObjectProvider()
    {
        return [
            'not an array of objects' => [
                [
                    'error' => 'not valid'
                ],
                false,
                Messages::ERRORS_OBJECT_NOT_ARRAY
            ],
            'error object not valid' => [
                [
                    [
                        'code' => 'E13',
                        '+not' => 'not valid',
                    ]
                ],
                false,
                null
            ],
            'error object not safe' => [
                [
                    [
                        'code' => 'E13',
                        'not valid' => 'not valid',
                    ]
                ],
                true,
                null
            ]
        ];
    }
}
