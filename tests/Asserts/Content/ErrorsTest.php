<?php

namespace VGirol\JsonApiAssert\Tests\Asserts\Content;

use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiAssert\Messages;
use VGirol\JsonApiAssert\Tests\TestCase;

class ErrorsTest extends TestCase
{
    /**
     * @test
     */
    public function errorsContains()
    {
        $expectedErrors = [
            [
                'status' => '415',
                'title' => 'Not Acceptable',
                'details' => 'description'
            ]
        ];
        $errors = [
            [
                'status' => '409',
                'title' => 'Conflict',
                'details' => 'description'
            ],
            [
                'status' => '415',
                'title' => 'Not Acceptable',
                'details' => 'description'
            ]
        ];

        Assert::assertErrorsContains($expectedErrors, $errors, false);
    }

    /**
     * @test
     * @dataProvider errorsContainsFailedProvider
     */
    public function errorsContainsFailed($expectedErrors, $errors, $strict, $failureMsg)
    {
        $this->setFailureException($failureMsg);

        Assert::assertErrorsContains($expectedErrors, $errors, $strict);
    }

    public function errorsContainsFailedProvider()
    {
        return [
            'errors object is not valid' => [
                [
                    [
                        'status' => '415',
                        'title' => 'Not Acceptable',
                        'details' => 'description'
                    ]
                ],
                [
                    [
                        'status' => 415,
                        'title' => 'Not Acceptable',
                        'details' => 'description'
                    ]
                ],
                false,
                Messages::ERROR_STATUS_IS_NOT_STRING
            ],
            'not enough errors' => [
                [
                    [
                        'status' => '409',
                        'title' => 'Conflict',
                        'details' => 'description'
                    ],
                    [
                        'status' => '409',
                        'title' => 'Conflict',
                        'details' => 'description'
                    ]
                ],
                [
                    [
                        'status' => '409',
                        'title' => 'Conflict',
                        'details' => 'description'
                    ]
                ],
                false,
                null
            ],
            'expected error not present' => [
                [
                    [
                        'status' => '409',
                        'title' => 'Conflict',
                        'details' => 'description'
                    ]
                ],
                [
                    [
                        'status' => '406',
                        'title' => 'Not Acceptable',
                        'details' => 'description'
                    ],
                    [
                        'status' => '415',
                        'title' => 'Not Acceptable',
                        'details' => 'description'
                    ]
                ],
                false,
                null
            ],
            'expected error not the same' => [
                [
                    [
                        'id' => '6',
                        'status' => '409',
                        'title' => 'Conflict',
                        'details' => 'description is different'
                    ]
                ],
                [
                    [
                        'status' => '406',
                        'title' => 'Not Acceptable',
                        'details' => 'description'
                    ],
                    [
                        'id' => '6',
                        'status' => '409',
                        'title' => 'Conflict',
                        'details' => 'description'
                    ]
                ],
                false,
                null
            ]
        ];
    }

    /**
     * @test
     */
    public function errorsContainsInvalidArguments()
    {
        $expectedErrors = [
            [
                'status' => 415,
                'title' => 'Not Acceptable',
                'details' => 'description'
            ]
        ];
        $errors = [
            [
                'status' => '415',
                'title' => 'Not Acceptable',
                'details' => 'description'
            ]
        ];
        $strict = false;
        $this->setInvalidArgumentException(1, 'errors object', $expectedErrors);

        Assert::assertErrorsContains($expectedErrors, $errors, $strict);
    }
}
