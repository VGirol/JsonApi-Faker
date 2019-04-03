<?php
namespace VGirol\JsonApiAssert\Tests\Asserts;

use VGirol\JsonApiAssert\Assert as JsonApiAssert;
use VGirol\JsonApiAssert\Tests\TestCase;
use VGirol\JsonApiAssert\Messages;

class MetaObjectTest extends TestCase
{
    /**
     * @test
     */
    public function meta_object_is_valid()
    {
        $data = [
            'key' => 'value',
            'another' => 'member'
        ];
        $strict = false;

        JsonApiAssert::assertIsValidMetaObject($data, $strict);
    }

    /**
     * @test
     * @dataProvider notValidMetaObjectProvider
     */
    public function meta_object_is_not_valid($json, $strict, $failureMessage)
    {
        $fn = function ($json, $strict) {
            JsonApiAssert::assertIsValidMetaObject($json, $strict);
        };

        JsonApiAssert::assertTestFail($fn, $failureMessage, $json, $strict);
    }

    public function notValidMetaObjectProvider()
    {
        return [
            'not an associative array' => [
                [
                    [
                        'key' => 'failed'
                    ]
                ],
                false,
                Messages::META_OBJECT_IS_NOT_ARRAY
            ],
            'array of objects' => [
                [
                    [ 'first' => 'element' ],
                    [ 'second' => 'element' ]
                ],
                false,
                Messages::META_OBJECT_IS_NOT_ARRAY
            ],
            'key is not valid' => [
                [
                    'key+' => 'value'
                ],
                false,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ],
            'key is not safe' => [
                [
                    'not valid' => 'due to the blank character'
                ],
                true,
                Messages::MEMBER_NAME_HAVE_RESERVED_CHARACTERS
            ]
        ];
    }
}
