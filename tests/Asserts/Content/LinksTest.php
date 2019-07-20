<?php

namespace VGirol\JsonApiAssert\Tests\Asserts\Content;

use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiAssert\Messages;
use VGirol\JsonApiAssert\Tests\TestCase;

class LinksTest extends TestCase
{
    /**
     * @test
     * @dataProvider linkObjectEqualsProvider
     */
    public function linkObjectEquals($expected, $link)
    {
        Assert::assertLinkObjectEquals($expected, $link);
    }

    public function linkObjectEqualsProvider()
    {
        return [
            'null' => [
                null,
                null
            ],
            'string' => [
                'url',
                'url'
            ],
            'with query string' => [
                'url?query1=test&query2=anything',
                'url?query1=test&query2=anything'
            ]
        ];
    }

    /**
     * @test
     * @dataProvider linkObjectEqualsFailedProvider
     */
    public function linkObjectEqualsFailed($expected, $link, $failureMsg)
    {
        $this->setFailureException($failureMsg);

        Assert::assertLinkObjectEquals($expected, $link);
    }

    public function linkObjectEqualsFailedProvider()
    {
        return [
            'must be null' => [
                null,
                'not null',
                null
            ],
            'must not be null' => [
                'url',
                null,
                null
            ],
            'must have query string' => [
                'url?query=test',
                'url',
                null
            ],
            'must not have query string' => [
                'url',
                'url?query=test',
                null
            ],
            'not same url' => [
                'url1',
                'url2',
                null
            ],
            'not same count of query strings' => [
                'url?query1=test',
                'url?query1=test&query2=anything',
                null
            ],
            'not same query strings' => [
                'url?query1=test',
                'url?query1=anything',
                null
            ]
        ];
    }

    /**
     * @test
     */
    public function linksObjectContains()
    {
        $name = 'self';
        $expected = 'url';
        $links = [
            'self' => 'url',
            'another' => 'anything'
        ];
        Assert::assertLinksObjectContains($name, $expected, $links);
    }

    /**
     * @test
     * @dataProvider linksObjectContainsFailedProvider
     */
    public function linksObjectContainsFailed($name, $expected, $links, $failureMsg)
    {
        $this->setFailureException($failureMsg);

        Assert::assertLinksObjectContains($name, $expected, $links);
    }

    public function linksObjectContainsFailedProvider()
    {
        return [
            'not has expected link member' => [
                'self',
                'url',
                [
                    'anything' => 'url'
                ],
                sprintf(Messages::HAS_MEMBER, 'self')
            ],
            'link is not as expected' => [
                'self',
                'url',
                [
                    'self' => 'url1'
                ],
                null
            ]
        ];
    }

    /**
     * @test
     */
    public function linksObjectEquals()
    {
        $expected = [
            'self' => 'url'
        ];
        $links = [
            'self' => 'url'
        ];
        Assert::assertLinksObjectEquals($expected, $links);
    }

    /**
     * @test
     * @dataProvider linksObjectEqualsFailedProvider
     */
    public function linksObjectEqualsFailed($expected, $links, $failureMsg)
    {
        $this->setFailureException($failureMsg);

        Assert::assertLinksObjectEquals($expected, $links);
    }

    public function linksObjectEqualsFailedProvider()
    {
        return [
            'not same count' => [
                [
                    'self' => 'url'
                ],
                [
                    'self' => 'url',
                    'anything' => 'url'
                ],
                null
            ],
            'link is not as expected' => [
                [
                    'self' => 'url'
                ],
                [
                    'self' => 'url2'
                ],
                null
            ]
        ];
    }
}
