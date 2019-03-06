<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use VGirol\JsonApiAssert\Assert as JsonApiAssert;
use VGirol\JsonApiAssert\Tests\TestCase;
use VGirol\JsonApiAssert\Messages;

class LinksObjectTest extends TestCase
{
    /**
     * @test
     * @dataProvider validLinkObjectProvider
     */
    public function link_object_is_valid($data)
    {
        JsonApiAssert::assertIsValidLinkObject($data);
    }

    public function validLinkObjectProvider()
    {
        return [
            'null value' => [
                null
            ],
            'as string' => [
                'validLink'
            ],
            'as object' => [
                [
                    'href' => 'validLink',
                    'meta' => [
                        'key' => 'value'
                    ]
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider notValidLinkObjectProvider
     */
    public function link_object_is_not_valid($data, $failureMessage)
    {
        $fn = function ($data) {
            JsonApiAssert::assertIsValidLinkObject($data);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data);
    }

    public function notValidLinkObjectProvider()
    {
        return [
            'not an array' => [
                666,
                Messages::LINK_OBJECT_IS_NOT_ARRAY
            ],
            'no "href" member' => [
                [
                    'meta' => 'error'
                ],
                Messages::LINK_OBJECT_MISS_HREF_MEMBER
            ],
            'not only allowed members' => [
                [
                    'href' => 'valid',
                    'meta' => 'valid',
                    'test' => 'error'
                ],
                Messages::ONLY_ALLOWED_MEMBERS
            ],
            'meta not valid' => [
                [
                    'href' => 'valid',
                    'meta' => 666
                ],
                Messages::META_OBJECT_IS_NOT_ARRAY
            ]
        ];
    }

    /**
     * @test
     */
    public function links_object_is_valid()
    {
        $data = [
            'self' => 'url',
            'related' => 'url'
        ];

        $allowed = [ 'self', 'related' ];

        JsonApiAssert::assertIsValidLinksObject($data, $allowed);
    }

    /**
     * @test
     * @dataProvider notValidLinksObjectProvider
     */
    public function links_object_is_not_valid($data, $allowed, $failureMessage)
    {
        $fn = function ($data, $allowed) {
            JsonApiAssert::assertIsValidLinksObject($data, $allowed);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $data, $allowed);
    }

    public function notValidLinksObjectProvider()
    {
        return [
            'not an array' => [
                'error',
                ['self', 'related'],
                Messages::LINKS_OBJECT_NOT_ARRAY
            ],
            'not only allowed members' => [
                [
                    'self' => 'valid',
                    'first' => 'valid',
                    'test' => 'error'
                ],
                ['self', 'related'],
                Messages::ONLY_ALLOWED_MEMBERS
            ],
            'link not valid' => [
                [
                    'self' => 666
                ],
                ['self', 'related'],
                Messages::LINK_OBJECT_IS_NOT_ARRAY
            ]
        ];
    }
}
