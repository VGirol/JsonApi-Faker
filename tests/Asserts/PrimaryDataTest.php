<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use VGirol\JsonApiAssert\Assert as JsonApiAssert;
use VGirol\JsonApiAssert\Tests\TestCase;
use VGirol\JsonApiAssert\Messages;

class PrimaryDataTest extends TestCase
{
    /**
     * @test
     * @dataProvider validDataForSingleResourceProvider
     */
    public function single_resource_is_valid($data)
    {
        JsonApiAssert::assertIsValidSingleResource($data, true);
    }

    public function validDataForSingleResourceProvider()
    {
        return [
            'resource identifier object' => [
                [
                    'type' => 'test',
                    'id' => '2'
                ]
            ],
            'resource object' => [
                [
                    'type' => 'test',
                    'id' => '2',
                    'attributes' => [
                        'anything' => 'ok'
                    ]
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider notValidDataForSingleResourceProvider
     */
    public function single_resource_is_not_valid($data, $strict, $failureMessage)
    {
        $fn = function ($data, $strict) {
            JsonApiAssert::assertIsValidSingleResource($data, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data, $strict);
    }

    public function notValidDataForSingleResourceProvider()
    {
        return [
            'resource identifier not valid' => [
                [
                    'id' => 666,
                    'type' => 'test'
                ],
                false,
                Messages::RESOURCE_ID_MEMBER_IS_NOT_STRING
            ],
            'resource object not valid' => [
                [
                    'type' => 'test',
                    'id' => '2',
                    'attributes' => [
                        'anything' => 'ok',
                        '+not valid' => 'error'
                    ]
                ],
                false,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ],
            'meta object has not safe member' => [
                [
                    'type' => 'test',
                    'id' => '2',
                    'attributes' => [
                        'anything' => 'ok',
                    ],
                    'meta' => [
                        'not safe' => 'due to blank character'
                    ]
                ],
                true,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ],
            'not an associative array' => [
                [
                    [
                        'type' => 'test',
                        'id' => '2',
                        'attributes' => [
                            'anything' => 'ok',
                        ]
                    ]
                ],
                true,
                Messages::MUST_NOT_BE_ARRAY_OF_OBJECTS
            ]
        ];
    }

    /**
     * @test
     * @dataProvider validPrimaryDataProvider
     */
    public function primary_data_is_valid($data, $strict)
    {
        JsonApiAssert::assertIsValidPrimaryData($data, $strict);
    }

    public function validPrimaryDataProvider()
    {
        return [
            'null' => [
                null,
                false
            ],
            'empty collection' => [
                [],
                false
            ],
            'resource collection' => [
                [
                    [
                        'type' => 'test',
                        'id' => '2'
                    ],
                    [
                        'type' => 'test',
                        'id' => '3'
                    ]
                ],
                false
            ],
            'unique resource' => [
                [
                    'type' => 'test',
                    'id' => '2',
                    'attributes' => [
                        'anything' => 'ok'
                    ]
                ],
                false
            ]
        ];
    }

    /**
     * @test
     * @dataProvider notValidPrimaryDataProvider
     */
    public function primary_data_is_not_valid($data, $strict, $failureMessage)
    {
        $fn = function ($data, $strict) {
            JsonApiAssert::assertIsValidPrimaryData($data, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data, $strict);
    }

    public function notValidPrimaryDataProvider()
    {
        return [
            'not an array' => [
                'bad',
                false,
                Messages::PRIMARY_DATA_NOT_ARRAY
            ],
            'not valid resource collection' => [
                [
                    [
                        'type' => 'test',
                        'id' => '1'
                    ],
                    [
                        'type' => 'test',
                        'id' => '2',
                        'attributes' => [
                            'anything' => 'valid'
                        ]
                    ]
                ],
                false,
                Messages::PRIMARY_DATA_SAME_TYPE
            ],
            'not safe meta member' => [
                [
                    'type' => 'test',
                    'id' => '2',
                    'attributes' => [
                        'anything' => 'valid'
                    ],
                    'meta' => [
                        'not valid' => 'due to the blank character'
                    ]
                ],
                true,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ]
        ];
    }
}
