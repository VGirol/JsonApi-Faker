<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
use VGirol\JsonApiConstant\Members;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;
use VGirol\JsonApiFaker\Factory\ErrorFactory;
use VGirol\JsonApiFaker\Messages;
use VGirol\JsonApiFaker\Tests\TestCase;

class ErrorFactoryTest extends TestCase
{
    /**
     * @test
     * @dataProvider setterProvider
     */
    public function setter($key, $value)
    {
        $factory = new ErrorFactory;
        $obj = $factory->set($key, $value);

        PHPUnit::assertEquals($value, $factory->{$key});
        PHPUnit::assertSame($obj, $factory);
    }

    public function setterProvider()
    {
        return [
            'error status' => [
                Members::ERROR_STATUS,
                'test'
            ],
            'error code' => [
                Members::ERROR_CODE,
                'test'
            ],
            'error title' => [
                Members::ERROR_TITLE,
                'test'
            ],
            'error details' => [
                Members::ERROR_DETAILS,
                'test'
            ]
        ];
    }

    /**
     * @test
     */
    public function setterFailed()
    {
        $key = 'badKey';
        $this->expectException(JsonApiFakerException::class);
        $this->expectExceptionMessage(
            sprintf(Messages::ERROR_OBJECT_INEXISTANT_KEY, $key)
        );

        $factory = new ErrorFactory;
        $factory->set($key, 'error');
    }

    /**
     * @test
     */
    public function setSource()
    {
        $expected = [
            'attr' => 'value'
        ];
        $factory = new ErrorFactory;
        $obj = $factory->setSource($expected);

        PHPUnit::assertEquals($expected, $factory->source);
        PHPUnit::assertSame($obj, $factory);
    }

    /**
     * @test
     */
    public function errorFactory()
    {
        $id = 'errorID';
        $status = '400';
        $meta = ['key' => 'value'];

        $expected = [
            Members::ID => $id,
            Members::ERROR_STATUS => $status,
            Members::META => $meta
        ];

        $factory = new ErrorFactory;
        $factory->setId($id)
            ->set(Members::ERROR_STATUS, $status)
            ->setMeta($meta);

        $result = $factory->toArray();

        PHPUnit::assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function errorFactoryFull()
    {
        $id = 'errorID';
        $status = '400';
        $meta = ['key' => 'value'];
        $links = [Members::LINK_ABOUT => 'url'];
        $code = 'errorCode';
        $title = 'error title';
        $details = 'error explanation';
        $source = [Members::ERROR_PARAMETER => 'query'];

        $expected = [
            Members::ID => $id,
            Members::ERROR_STATUS => $status,
            Members::META => $meta,
            Members::LINKS => $links,
            Members::ERROR_CODE => $code,
            Members::ERROR_TITLE => $title,
            Members::ERROR_DETAILS => $details,
            Members::ERROR_SOURCE => $source
        ];

        $factory = new ErrorFactory;
        $factory->setId($id)
            ->set(Members::ERROR_STATUS, $status)
            ->setMeta($meta)
            ->setLinks($links)
            ->set(Members::ERROR_CODE, $code)
            ->set(Members::ERROR_TITLE, $title)
            ->set(Members::ERROR_DETAILS, $details)
            ->setSource($source);

        $result = $factory->toArray();

        PHPUnit::assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function fake()
    {
        $factory = new ErrorFactory;

        PHPUnit::assertEmpty($factory->getId());
        PHPUnit::assertEmpty($factory->getLinks());
        PHPUnit::assertEmpty($factory->getMeta());
        PHPUnit::assertEmpty($factory->status);
        PHPUnit::assertEmpty($factory->code);
        PHPUnit::assertEmpty($factory->title);
        PHPUnit::assertEmpty($factory->details);
        PHPUnit::assertEmpty($factory->source);

        $obj = $factory->fake();

        PHPUnit::assertSame($obj, $factory);
        PHPUnit::assertNotEmpty($factory->getId());

        PHPUnit::assertNotEmpty($factory->getLinks());
        PHPUnit::assertEquals(1, count($factory->getLinks()));
        PHPUnit::assertEquals(Members::LINK_ABOUT, array_keys($factory->getLinks())[0]);

        PHPUnit::assertNotEmpty($factory->getMeta());
        PHPUnit::assertEquals(5, count($factory->getMeta()));

        PHPUnit::assertNotEmpty($factory->status);
        PHPUnit::assertIsString($factory->status);

        PHPUnit::assertNotEmpty($factory->code);
        PHPUnit::assertIsString($factory->code);
        PHPUnit::assertGreaterThanOrEqual(1, intval($factory->code));
        PHPUnit::assertLessThanOrEqual(100, intval($factory->code));

        PHPUnit::assertNotEmpty($factory->title);
        PHPUnit::assertIsString($factory->title);

        PHPUnit::assertNotEmpty($factory->details);
        PHPUnit::assertIsString($factory->details);

        PHPUnit::assertNotEmpty($factory->source);
        PHPUnit::assertIsArray($factory->source);
        PHPUnit::assertEquals(1, count($factory->source));
        PHPUnit::assertEquals(Members::ERROR_PARAMETER, array_keys($factory->source)[0]);

        Assert::assertIsValidErrorObject($factory->toArray(), true);
    }
}
