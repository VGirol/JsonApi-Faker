<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiAssert\Assert;
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
            'status' => [
                'status',
                'test'
            ],
            'code' => [
                'code',
                'test'
            ],
            'title' => [
                'title',
                'test'
            ],
            'details' => [
                'details',
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
            'id' => $id,
            'status' => $status,
            'meta' => $meta
        ];

        $factory = new ErrorFactory;
        $factory->setId($id)
            ->set('status', $status)
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
        $links = ['about' => 'url'];
        $code = 'errorCode';
        $title = 'error title';
        $details = 'error explanation';
        $source = ['parameter' => 'query'];

        $expected = [
            'id' => $id,
            'status' => $status,
            'meta' => $meta,
            'links' => $links,
            'code' => $code,
            'title' => $title,
            'details' => $details,
            'source' => $source
        ];

        $factory = new ErrorFactory;
        $factory->setId($id)
            ->set('status', $status)
            ->setMeta($meta)
            ->setLinks($links)
            ->set('code', $code)
            ->set('title', $title)
            ->set('details', $details)
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

        PHPUnit::assertEmpty($factory->id);
        PHPUnit::assertEmpty($factory->links);
        PHPUnit::assertEmpty($factory->meta);
        PHPUnit::assertEmpty($factory->status);
        PHPUnit::assertEmpty($factory->code);
        PHPUnit::assertEmpty($factory->title);
        PHPUnit::assertEmpty($factory->details);
        PHPUnit::assertEmpty($factory->source);

        $obj = $factory->fake();

        PHPUnit::assertSame($obj, $factory);
        PHPUnit::assertNotEmpty($factory->id);

        PHPUnit::assertNotEmpty($factory->links);
        PHPUnit::assertEquals(1, count($factory->links));
        PHPUnit::assertEquals('about', array_keys($factory->links)[0]);

        PHPUnit::assertNotEmpty($factory->meta);
        PHPUnit::assertEquals(5, count($factory->meta));

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
        PHPUnit::assertEquals('parameter', array_keys($factory->source)[0]);

        Assert::assertIsValidErrorObject($factory->toArray(), true);
    }
}
