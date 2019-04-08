<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use VGirol\JsonApiAssert\Assert as JsonApiAssert;
use VGirol\JsonApiAssert\Messages;
use VGirol\JsonApiAssert\Tests\TestCase;

class ResourceObjectTest extends TestCase
{
    /**
     * @test
     */
    public function resourceFieldNameIsNotForbidden()
    {
        $name = 'test';

        JsonApiAssert::assertIsNotForbiddenResourceFieldName($name);
    }

    /**
     * @test
     * @dataProvider resourceFieldNameIsForbiddenProvider
     */
    public function resourceFieldNameIsForbidden($name, $failureMessage)
    {
        $fn = function ($name) {
            JsonApiAssert::assertIsNotForbiddenResourceFieldName($name);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $name);
    }

    public function resourceFieldNameIsForbiddenProvider()
    {
        return [
            'type' => [
                'type',
                Messages::FIELDS_NAME_NOT_ALLOWED
            ],
            'id' => [
                'id',
                Messages::FIELDS_NAME_NOT_ALLOWED
            ]
        ];
    }

    /**
     * @test
     */
    public function resourceLinksObjectIsValid()
    {
        $links = [
            'self' => 'url'
        ];
        $strict = false;

        JsonApiAssert::assertIsValidResourceLinksObject($links, $strict);
    }

    /**
     * @test
     * @dataProvider notValidResourceLinksObjectProvider
     */
    public function resourceLinksObjectIsNotValid($json, $strict, $failureMessage)
    {
        $fn = function ($json, $strict) {
            JsonApiAssert::assertIsValidResourceLinksObject($json, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $json, $strict);
    }

    public function notValidResourceLinksObjectProvider()
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
    public function resourceHasValidTopLevelStructure()
    {
        $data = [
            'id' => '1',
            'type' => 'articles',
            'attributes' => [
                'title' => 'test'
            ],
            'links' => [
                'self' => '/articles/1'
            ],
            'meta' => [
                'member' => 'is valid'
            ],
            'relationships' => [
                'author' => [
                    'links' => [
                        'self' => '/articles/1/relationships/author',
                        'related' => '/articles/1/author'
                    ],
                    'data' => [
                        'type' => 'people',
                        'id' => '9'
                    ]
                ]
            ]
        ];

        JsonApiAssert::assertResourceObjectHasValidTopLevelStructure($data);
    }

    /**
     * @test
     * @dataProvider hasotValidTopLevelStructureProvider
     */
    public function resourceHasNotValidTopLevelStructure($data, $failureMessage)
    {
        $fn = function ($response) {
            JsonApiAssert::assertResourceObjectHasValidTopLevelStructure($response);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data);
    }

    public function hasotValidTopLevelStructureProvider()
    {
        return [
            'not an array' => [
                'failed',
                Messages::RESOURCE_IS_NOT_ARRAY
            ],
            'id is missing' => [
                [
                    'type' => 'test',
                    'attributes' => [
                        'attr' => 'value'
                    ]
                ],
                Messages::RESOURCE_ID_MEMBER_IS_ABSENT
            ],
            'type is missing' => [
                [
                    'id' => '1',
                    'attributes' => [
                        'attr' => 'value'
                    ]
                ],
                Messages::RESOURCE_TYPE_MEMBER_IS_ABSENT
            ],
            'missing mandatory member' => [
                [
                    'id' => '1',
                    'type' => 'test'
                ],
                sprintf(
                    Messages::CONTAINS_AT_LEAST_ONE,
                    implode(', ', ['attributes', 'relationships', 'links', 'meta'])
                )
            ],
            'member not allowed' => [
                [
                    'id' => '1',
                    'type' => 'test',
                    'meta' => [
                        'anything' => 'good'
                    ],
                    'wrong' => 'wrong'
                ],
                Messages::ONLY_ALLOWED_MEMBERS
            ]
        ];
    }

    /**
     * @test
     */
    public function resourceIdMemberIsValid()
    {
        $data = [
            'id' => '1',
            'type' => 'test'
        ];

        JsonApiAssert::assertResourceIdMember($data);
    }

    /**
     * @test
     * @dataProvider notValidResourceIdMemberProvider
     */
    public function resourceIdMemberIsNotValid($data, $failureMessage)
    {
        $fn = function ($response) {
            JsonApiAssert::assertResourceIdMember($response);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data);
    }

    public function notValidResourceIdMemberProvider()
    {
        return [
            'id is empty' => [
                [
                    'id' => '',
                    'type' => 'test'
                ],
                Messages::RESOURCE_ID_MEMBER_IS_EMPTY
            ],
            'id is not a string' => [
                [
                    'id' => 1,
                    'type' => 'test'
                ],
                Messages::RESOURCE_ID_MEMBER_IS_NOT_STRING
            ]
        ];
    }

    /**
     * @test
     */
    public function resourceTypeMemberIsValid()
    {
        $data = [
            'id' => '1',
            'type' => 'test'
        ];
        $strict = false;

        JsonApiAssert::assertResourceTypeMember($data, $strict);
    }

    /**
     * @test
     * @dataProvider notValidResourceTypeMemberProvider
     */
    public function resourceTypeMemberIsNotValid($json, $strict, $failureMessage)
    {
        $fn = function ($json, $strict) {
            JsonApiAssert::assertResourceTypeMember($json, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $json, $strict);
    }

    public function notValidResourceTypeMemberProvider()
    {
        return [
            'type is empty' => [
                [
                    'id' => '1',
                    'type' => ''
                ],
                false,
                Messages::RESOURCE_TYPE_MEMBER_IS_EMPTY
            ],
            'type is not a string' => [
                [
                    'id' => '1',
                    'type' => 404
                ],
                false,
                Messages::RESOURCE_TYPE_MEMBER_IS_NOT_STRING
            ],
            'type value has forbidden characters' => [
                [
                    'id' => '1',
                    'type' => 'test+1'
                ],
                false,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ],
            'type value has not safe characters' => [
                [
                    'id' => '1',
                    'type' => 'test 1'
                ],
                true,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ]
        ];
    }

    /**
     * @test
     */
    public function resourceFieldIsValid()
    {
        $data = [
            'id' => '1',
            'type' => 'articles',
            'attributes' => [
                'title' => 'test'
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'people',
                        'id' => '9'
                    ]
                ]
            ]
        ];

        JsonApiAssert::assertHasValidFields($data);
    }

    /**
     * @test
     * @dataProvider isNotValidResourceFieldProvider
     */
    public function resourceFieldIsNotValid($data, $failureMessage)
    {
        $fn = function ($response) {
            JsonApiAssert::assertHasValidFields($response);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data);
    }

    public function isNotValidResourceFieldProvider()
    {
        return [
            'attribute and relationship with the same name' => [
                [
                    'id' => '1',
                    'type' => 'articles',
                    'attributes' => [
                        'title' => 'test'
                    ],
                    'relationships' => [
                        'title' => [
                            'data' => [
                                'type' => 'people',
                                'id' => '9'
                            ]
                        ]
                    ]
                ],
                Messages::FIELDS_HAVE_SAME_NAME
            ],
            'attribute named type or id' => [
                [
                    'id' => '1',
                    'type' => 'articles',
                    'attributes' => [
                        'title' => 'test',
                        'id' => 'not valid'
                    ]
                ],
                Messages::FIELDS_NAME_NOT_ALLOWED
            ],
            'relationship named type or id' => [
                [
                    'id' => '1',
                    'type' => 'articles',
                    'attributes' => [
                        'title' => 'test'
                    ],
                    'relationships' => [
                        'type' => [
                            'data' => [
                                'type' => 'people',
                                'id' => '9'
                            ]
                        ]
                    ]
                ],
                Messages::FIELDS_NAME_NOT_ALLOWED
            ]
        ];
    }

    /**
     * @test
     */
    public function resourceObjectIsValid()
    {
        $data = [
            'id' => '1',
            'type' => 'articles',
            'attributes' => [
                'title' => 'test'
            ],
            'links' => [
                'self' => '/articles/1'
            ],
            'meta' => [
                'member' => 'is valid'
            ],
            'relationships' => [
                'author' => [
                    'links' => [
                        'self' => '/articles/1/relationships/author',
                        'related' => '/articles/1/author'
                    ],
                    'data' => [
                        'type' => 'people',
                        'id' => '9'
                    ]
                ]
            ]
        ];
        $strict = false;

        JsonApiAssert::assertIsValidResourceObject($data, $strict);
    }

    /**
     * @test
     * @dataProvider isNotValidResourceObjectProvider
     */
    public function resourceObjectIsNotValid($json, $strict, $failureMessage)
    {
        $fn = function ($json, $strict) {
            JsonApiAssert::assertIsValidResourceObject($json, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $json, $strict);
    }

    public function isNotValidResourceObjectProvider()
    {
        return [
            'not an array' => [
                'failed',
                false,
                Messages::RESOURCE_IS_NOT_ARRAY
            ],
            'id is not valid' => [
                [
                    'id' => 1,
                    'type' => 'test',
                    'attributes' => [
                        'title' => 'test'
                    ]
                ],
                false,
                Messages::RESOURCE_ID_MEMBER_IS_NOT_STRING
            ],
            'type is not valid' => [
                [
                    'id' => '1',
                    'type' => 404,
                    'attributes' => [
                        'title' => 'test'
                    ]
                ],
                false,
                Messages::RESOURCE_TYPE_MEMBER_IS_NOT_STRING
            ],
            'missing mandatory member' => [
                [
                    'id' => '1',
                    'type' => 'test'
                ],
                false,
                sprintf(
                    Messages::CONTAINS_AT_LEAST_ONE,
                    implode(', ', ['attributes', 'relationships', 'links', 'meta'])
                )
            ],
            'member not allowed' => [
                [
                    'id' => '1',
                    'type' => 'test',
                    'attributes' => [
                        'title' => 'test'
                    ],
                    'wrong' => 'wrong'
                ],
                false,
                Messages::ONLY_ALLOWED_MEMBERS
            ],
            'attributes not valid' => [
                [
                    'id' => '1',
                    'type' => 'test',
                    'attributes' => [
                        'title' => 'test',
                        'key+' => 'wrong'
                    ]
                ],
                false,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ],
            'fields not valid (attribute and relationship with the same name)' => [
                [
                    'id' => '1',
                    'type' => 'articles',
                    'attributes' => [
                        'title' => 'test'
                    ],
                    'relationships' => [
                        'title' => [
                            'data' => [
                                'type' => 'people',
                                'id' => '9'
                            ]
                        ]
                    ]
                ],
                false,
                Messages::FIELDS_HAVE_SAME_NAME
            ],
            'fields not valid (attribute named "type" or "id")' => [
                [
                    'id' => '1',
                    'type' => 'articles',
                    'attributes' => [
                        'title' => 'test',
                        'id' => 'not valid'
                    ]
                ],
                false,
                Messages::FIELDS_NAME_NOT_ALLOWED
            ],
            'relationship not valid' => [
                [
                    'id' => '1',
                    'type' => 'articles',
                    'attributes' => [
                        'title' => 'test'
                    ],
                    'relationships' => [
                        'author' => [
                            'data' => [
                                'type' => 'people',
                                'id' => '9',
                                'wrong' => 'not valid'
                            ]
                        ]
                    ]
                ],
                false,
                Messages::ONLY_ALLOWED_MEMBERS
            ],
            'meta with not safe member name' => [
                [
                    'id' => '1',
                    'type' => 'articles',
                    'attributes' => [
                        'title' => 'test'
                    ],
                    'meta' => [
                        'not valid' => 'due to the blank character'
                    ]
                ],
                true,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ],
            'links not valid' => [
                [
                    'id' => '1',
                    'type' => 'articles',
                    'attributes' => [
                        'title' => 'test'
                    ],
                    'links' => [
                        'not valid' => 'bad'
                    ]
                ],
                true,
                Messages::ONLY_ALLOWED_MEMBERS
            ]
        ];
    }
}
