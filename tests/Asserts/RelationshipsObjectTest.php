<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use VGirol\JsonApiAssert\Assert as JsonApiAssert;
use VGirol\JsonApiAssert\Tests\TestCase;
use VGirol\JsonApiAssert\Messages;

class RelationshipsObjectTest extends TestCase
{
    /**
     * @test
     * @dataProvider validResourceLinkageProvider
     */
    public function resource_linkage_is_valid($data)
    {
        JsonApiAssert::assertIsValidResourceLinkage($data);
    }

    public function validResourceLinkageProvider()
    {
        return [
            'null' => [
                null
            ],
            'empty array' => [
                []
            ],
            'single resource identifier object' => [
                [
                    'type' => 'people',
                    'id' => '9'
                ]
            ],
            'array of resource identifier objects' => [
                [
                    [
                        'type' => 'people',
                        'id' => '9'
                    ],
                    [
                        'type' => 'people',
                        'id' => '10'
                    ]
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider notValidResourceLinkageProvider
     */
    public function resource_linkage_is_not_valid($data, $failureMessage)
    {
        $fn = function ($data) {
            JsonApiAssert::assertIsValidResourceLinkage($data);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data);
    }

    public function notValidResourceLinkageProvider()
    {
        return [
            'not an array' => [
                'not valid',
                Messages::RESOURCE_LINKAGE_NOT_ARRAY
            ],
            'not valid single resource identifier object' => [
                [
                    'type' => 'people',
                    'id' => '9',
                    'anything' => 'not valid'
                ],
                Messages::ONLY_ALLOWED_MEMBERS
            ],
            'not valid array of resource identifier objects' => [
                [
                    [
                        'type' => 'people',
                        'id' => '9',
                        'anything' => 'not valid'
                    ],
                    [
                        'type' => 'people',
                        'id' => '10'
                    ]
                ],
                Messages::ONLY_ALLOWED_MEMBERS
            ]
        ];
    }

    /**
     * @test
     * @dataProvider validRelationshipObjectProvider
     */
    public function relationship_object_is_valid($data)
    {
        JsonApiAssert::assertIsValidRelationshipObject($data);
    }

    public function validRelationshipObjectProvider()
    {
        return [
            'short' => [
                [
                    'data' => [
                        'type' => 'test',
                        'id' => '2'
                    ]
                ]
            ],
            'long' => [
                [
                    'data' => [
                        [
                            'type' => 'author',
                            'id' => '2'
                        ],
                        [
                            'type' => 'author',
                            'id' => '3'
                        ]
                    ],
                    'links' => [
                        'self' => 'http://example.com/articles/1/relationships/author',
                        'related' => 'http://example.com/articles/1/author',
                        'first' => 'url',
                        'next' => 'url'
                    ],
                    'meta' => [
                        'anything' => 'valid'
                    ]
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider notValidRelationshipObjectProvider
     */
    public function relationship_object_is_not_valid($data, $failureMessage)
    {
        $fn = function ($data) {
            JsonApiAssert::assertIsValidRelationshipObject($data);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data);
    }

    public function notValidRelationshipObjectProvider()
    {
        return [
            'mandatory member miss' => [
                [
                    'anything' => [
                        'not' => 'valid'
                    ]
                ],
                sprintf(Messages::CONTAINS_AT_LEAST_ONE, implode(', ', ['links', 'data', 'meta']))
            ],
            'array of resource identifier objects without pagination' => [
                [
                    [
                        'data' => [
                            [
                                'type' => 'test',
                                'id' => '2'
                            ],
                            [
                                'type' => 'test',
                                'id' => '3'
                            ]
                        ],
                        'links' => [
                            'self' => 'url',
                            'related' => 'url'
                        ]
                    ]
                ],
                sprintf(Messages::CONTAINS_AT_LEAST_ONE, implode(', ', ['links', 'data', 'meta']))
            ]
        ];
    }

    /**
     * @test
     */
    public function relationships_object_is_valid()
    {
        $data = [
            'author' => [
                'links' => [
                    'self' => 'http://example.com/articles/1/relationships/author',
                    'related' => 'http://example.com/articles/1/author'
                ],
                'data' => [
                    'type' => 'people',
                    'id' => '9'
                ]
            ]
        ];

        JsonApiAssert::assertIsValidRelationshipsObject($data);
    }

    /**
     * @test
     * @dataProvider notValidRelationshipsObjectProvider
     */
    public function relationships_object_is_not_valid($data, $failureMessage)
    {
        $fn = function ($data) {
            JsonApiAssert::assertIsValidRelationshipsObject($data);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data);
    }

    public function notValidRelationshipsObjectProvider()
    {
        return [
            'an array of objects' => [
                [
                    ['test' => 'not valid'],
                    ['anything' => 'not valid']
                ],
                Messages::MUST_NOT_BE_ARRAY_OF_OBJECTS
            ],
            'no valid member name' => [
                [
                    'author+' => [
                        'data' => [
                            'type' => 'people',
                            'id' => '9'
                        ]
                    ]
                ],
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ]
        ];
    }
}
