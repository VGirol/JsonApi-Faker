<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use VGirol\JsonApiAssert\Messages;
use VGirol\JsonApiAssert\Tests\TestCase;
use VGirol\JsonApiAssert\Assert as JsonApiAssert;

class IncludedTest extends TestCase
{
    /**
     * @test
     * @dataProvider validIncludedProvider
     */
    public function compound_document_is_valid($json, $strict)
    {
        JsonApiAssert::assertIsValidIncludedCollection($json['included'], $json['data'], $strict);
    }

    public function validIncludedProvider()
    {
        return [
            'with data' => [
                [
                    'data' => [
                        [
                            'type' => 'articles',
                            'id' => '1',
                            'relationships' => [
                                'test' => [
                                    'data' => [
                                        'type' => 'first',
                                        'id' => '10'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'type' => 'articles',
                            'id' => '2',
                            'attributes' => [
                                'title' => 'Rails is Omakase'
                            ]
                        ]
                    ],
                    'included' => [
                        [
                            'type' => 'first',
                            'id' => '10',
                            'attributes' => [
                                'title' => 'test'
                            ],
                            'relationships' => [
                                'test' => [
                                    'data' => [
                                        'type' => 'second',
                                        'id' => '12'
                                    ]
                                ]
                            ]
                        ],
                        [
                            'type' => 'second',
                            'id' => '12',
                            'attributes' => [
                                'title' => 'another test'
                            ]
                        ]
                    ]
                ],
                false
            ]
        ];
    }

    /**
     * @test
     * @dataProvider notValidIncludedProvider
     */
    public function compound_document_is_not_valid($json, $strict, $failureMessage)
    {
        $fn = function ($json, $strict) {
            JsonApiAssert::assertIsValidIncludedCollection($json['included'], $json['data'], $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $json, $strict);
    }

    public function notValidIncludedProvider()
    {
        return [
            'included member is not a resource collection' => [
                [
                    'data' => [],
                    'included' => [
                        'id' => '1',
                        'type' => 'test'
                    ]
                ],
                false,
                Messages::MUST_BE_ARRAY_OF_OBJECTS
            ],
            'one included resource is not identified by a resource identifier object' => [
                [
                    'data' => [
                        'type' => 'articles',
                        'id' => '1',
                        'relationships' => [
                            'test' => [
                                'data' => [
                                    'type' => 'first',
                                    'id' => '10'
                                ]
                            ]
                        ]
                    ],
                    'included' => [
                        [
                            'type' => 'first',
                            'id' => '10',
                            'attributes' => [
                                'title' => 'test'
                            ]
                        ],
                        [
                            'type' => 'second',
                            'id' => '12',
                            'attributes' => [
                                'title' => 'another'
                            ]
                        ]
                    ]
                ],
                false,
                Messages::INCLUDED_RESOURCE_NOT_LINKED
            ],
            'a resource is included twice' => [
                [
                    'data' => [
                        'type' => 'articles',
                        'id' => '1',
                        'relationships' => [
                            'test' => [
                                'data' => [
                                    'type' => 'first',
                                    'id' => '10'
                                ]
                            ]
                        ]
                    ],
                    'included' => [
                        [
                            'type' => 'first',
                            'id' => '10',
                            'attributes' => [
                                'title' => 'test'
                            ]
                        ],
                        [
                            'type' => 'first',
                            'id' => '10',
                            'attributes' => [
                                'title' => 'test'
                            ]
                        ]
                    ]
                ],
                false,
                Messages::COMPOUND_DOCUMENT_ONLY_ONE_RESOURCE
            ],
            'an included resource is not valid' => [
                [
                    'data' => [
                        'type' => 'articles',
                        'id' => '1',
                        'relationships' => [
                            'test' => [
                                'data' => [
                                    'type' => 'first',
                                    'id' => '10'
                                ]
                            ]
                        ]
                    ],
                    'included' => [
                        [
                            'type' => 'first',
                            'id' => '10'
                        ]
                    ]
                ],
                false,
                sprintf(Messages::CONTAINS_AT_LEAST_ONE, implode(', ', ['attributes', 'relationships', 'links', 'meta']))
            ]
        ];
    }
}
