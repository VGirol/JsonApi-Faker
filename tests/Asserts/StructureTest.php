<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use VGirol\JsonApiAssert\Messages;
use VGirol\JsonApiAssert\Tests\TestCase;
use VGirol\JsonApiAssert\Assert as JsonApiAssert;

class StructureTest extends TestCase
{
    /**
     * @test
     * @dataProvider validStructureProvider
     */
    public function document_has_valid_structure($data, $strict)
    {
        JsonApiAssert::assertHasValidStructure($data, $strict);
    }

    public function validStructureProvider()
    {
        return [
            'with data' => [
                [
                    'links' => [
                        'self' => 'http://example.com/articles',
                        'first' => 'url',
                        'last' => 'url'
                    ],
                    'data' => [
                        [
                            'type' => 'articles',
                            'id' => '1',
                            'attributes' => [
                                'title' => 'JSON:API paints my bikeshed!'
                            ]
                        ],
                        [
                            'type' => 'articles',
                            'id' => '2',
                            'attributes' => [
                                'title' => 'Rails is Omakase'
                            ],
                            'relationships' => [
                                'test' => [
                                    'data' => [
                                        'type' => 'relation',
                                        'id' => '12'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'meta' => [
                        'anything' => 'valid'
                    ],
                    'included' => [
                        [
                            'type' => 'relation',
                            'id' => '12',
                            'attributes' => [
                                'anything' => 'valid'
                            ]
                        ]
                    ]
                ],
                false
            ],
            'with errors' => [
                [
                    'errors' => [
                        [
                            'code' => 'E13'
                        ],
                        [
                            'code' => 'E14'
                        ]
                    ],
                    'jsonapi' => [
                        'version' => 'valid'
                    ]
                ],
                false
            ]
        ];
    }

    /**
     * @test
     * @dataProvider notValidStructureProvider
     */
    public function document_has_not_valid_structure($data, $strict, $failureMessage)
    {
        $fn = function ($data, $strict) {
            JsonApiAssert::assertHasValidStructure($data, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data, $strict);
    }

    public function notValidStructureProvider()
    {
        return [
            'no valid top-level member' => [
                [
                    'links' => [
                        'self' => 'http://example.com/articles',
                    ],
                    'data' => [
                        'type' => 'articles',
                        'id' => '1',
                        'attributes' => [
                            'title' => 'First'
                        ]
                    ],
                    'anything' => 'not valid'
                ],
                false,
                Messages::ONLY_ALLOWED_MEMBERS
            ],
            'no valid primary data' => [
                [
                    'links' => [
                        'self' => 'http://example.com/articles',
                    ],
                    'data' => [
                        'type' => 'articles',
                        'id' => 1,
                        'attributes' => [
                            'title' => 'First'
                        ]
                    ]
                ],
                false,
                Messages::RESOURCE_ID_MEMBER_IS_NOT_STRING
            ],
            'no valid errors object' => [
                [
                    'errors' => [
                        'wrong' => 'not valid'
                    ]
                ],
                false,
                Messages::ERRORS_OBJECT_NOT_ARRAY
            ],
            'no valid meta' => [
                [
                    'meta' => [
                        'key+' => 'not valid'
                    ],
                    'data' => [
                        'type' => 'articles',
                        'id' => '1',
                        'attributes' => [
                            'title' => 'First'
                        ]
                    ]
                ],
                false,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ],
            'no valid jsonapi' => [
                [
                    'jsonapi' => [
                        'version' => 1
                    ],
                    'data' => [
                        'type' => 'articles',
                        'id' => '1',
                        'attributes' => [
                            'title' => 'First'
                        ]
                    ]
                ],
                false,
                Messages::JSONAPI_VERSION_IS_NOT_STRING
            ],
            'no valid included' => [
                [
                    'included' => [
                        'key' => 'not valid'
                    ],
                    'data' => [
                        'type' => 'articles',
                        'id' => '1',
                        'attributes' => [
                            'title' => 'First'
                        ]
                    ]
                ],
                false,
                Messages::MUST_BE_ARRAY_OF_OBJECTS
            ],
            'bad value for top-level links member' => [
                [
                    'links' => [
                        'self' => 'http://example.com/articles',
                        'forbidden' => 'not valid'
                    ],
                    'data' => [
                        'type' => 'articles',
                        'id' => '1',
                        'attributes' => [
                            'title' => 'First'
                        ]
                    ]
                ],
                false,
                Messages::ONLY_ALLOWED_MEMBERS
            ]
        ];
    }

    /**
     * @test
     */
    public function top_level_links_object_is_valid()
    {
        $links = [
            'self' => 'url'
        ];
        $strict = false;

        JsonApiAssert::assertIsValidTopLevelLinksMember($links, $strict);
    }

    /**
     * @test
     * @dataProvider notValidTopLevelLinksObjectProvider
     */
    public function top_level_links_object_is_not_valid($json, $strict, $failureMessage)
    {
        $fn = function ($json, $strict) {
            JsonApiAssert::assertIsValidTopLevelLinksMember($json, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $json, $strict);
    }

    public function notValidTopLevelLinksObjectProvider()
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
     */
    public function included_collection_is_valid()
    {
        $included = [
            [
                'type' => 'relation',
                'id' => '12',
                'attributes' => [
                    'subtitle' => 'world'
                ]
            ]
        ];
        $data = [
            'type' => 'test',
            'id' => '1',
            'attributes' => [
                'title' => 'hello'
            ],
            'relationships' => [
                'anonymous' => [
                    'meta' => [
                        'key' => 'value'
                    ]
                ],
                'relatedToTest' => [
                    'data' => [
                        'type' => 'relation',
                        'id' => '12'
                    ]
                ]
            ]
        ];
        $strict = false;

        JsonApiAssert::assertIsValidIncludedCollection($included, $data, $strict);
    }

    /**
     * @test
     * @dataProvider notValidIncludedCollectionProvider
     */
    public function included_collection_is_not_valid($included, $data, $strict, $failureMessage)
    {
        $fn = function ($included, $data, $strict) {
            JsonApiAssert::assertIsValidIncludedCollection($included, $data, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $included, $data, $strict);
    }

    public function notValidIncludedCollectionProvider()
    {
        return [
            'include is not an array of objects' => [
                [
                    'key' => 'not valid'
                ],
                [
                    'type' => 'test',
                    'id' => '1',
                    'attributes' => [
                        'title' => 'hello'
                    ],
                    'relationships' => [
                        'relatedToTest' => [
                            'data' => [
                                'type' => 'relation',
                                'id' => '13'
                            ]
                        ]
                    ]
                ],
                false,
                Messages::MUST_BE_ARRAY_OF_OBJECTS
            ],
            'included resource not linked' => [
                [
                    [
                        'type' => 'relation',
                        'id' => '12',
                        'attributes' => [
                            'subtitle' => 'world'
                        ]
                    ]
                ],
                [
                    'type' => 'test',
                    'id' => '1',
                    'attributes' => [
                        'title' => 'hello'
                    ],
                    'relationships' => [
                        'relatedToTest' => [
                            'data' => [
                                'type' => 'relation',
                                'id' => '13'
                            ]
                        ]
                    ]
                ],
                false,
                Messages::INCLUDED_RESOURCE_NOT_LINKED
            ]
        ];
    }
}
