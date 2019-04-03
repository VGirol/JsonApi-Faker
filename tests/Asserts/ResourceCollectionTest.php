<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use VGirol\JsonApiAssert\Assert as JsonApiAssert;
use VGirol\JsonApiAssert\Tests\TestCase;
use VGirol\JsonApiAssert\Messages;

class ResourceCollectionTest extends TestCase
{
    /**
     * @test
     * @dataProvider validDataForResourceCollectionProvider
     */
    public function resource_collection_is_valid($data, $strict)
    {
        JsonApiAssert::assertIsValidResourceCollection($data, true, $strict);
    }

    public function validDataForResourceCollectionProvider()
    {
        return [
            'resource identifier objects' => [
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
            'resource objects' => [
                [
                    [
                        'type' => 'test',
                        'id' => '2',
                        'attributes' => [
                            'anything' => 'ok'
                        ]
                    ],
                    [
                        'type' => 'test',
                        'id' => '3',
                        'attributes' => [
                            'anything' => 'ok'
                        ]
                    ]
                ],
                false
            ],
            'only one item' => [
                [
                    [
                        'type' => 'test',
                        'id' => '2'
                    ]
                ],
                false
            ],
            'empty collection' => [
                [],
                false
            ],
        ];
    }

    /**
     * @test
     * @dataProvider notValidDataForResourceCollectionProvider
     */
    public function resource_collection_is_not_valid($data, $strict, $failureMessage)
    {
        $fn = function ($data, $strict) {
            JsonApiAssert::assertIsValidResourceCollection($data, true, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data, $strict);
    }

    public function notValidDataForResourceCollectionProvider()
    {
        return [
            'not an array of objects' => [
                [
                    'anything' => 'false'
                ],
                false,
                Messages::MUST_BE_ARRAY_OF_OBJECTS
            ],
            'not all objects are of same type' => [
                [
                    [
                        'type' => 'test',
                        'id' => '2',
                        'attributes' => [
                            'anything' => 'ok'
                        ]
                    ],
                    [
                        'type' => 'test',
                        'id' => '3'
                    ]
                ],
                false,
                Messages::PRIMARY_DATA_SAME_TYPE
            ],
            'meta has not safe member name' => [
                [
                    [
                        'type' => 'test',
                        'id' => '2',
                        'meta' => [
                            'not safe' => 'due to the blank character'
                        ]
                    ],
                    [
                        'type' => 'test',
                        'id' => '3'
                    ]
                ],
                true,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ]
        ];
    }
}
