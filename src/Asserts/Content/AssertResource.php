<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Asserts\Content;

use PHPUnit\Framework\Assert as PHPUnit;

trait AssertResource
{
    /**
     * Asserts that a resource object correspond to a given model.
     *
     * @param array $expected
     * @param array $json
     */
    public static function assertResourceObjectEquals($expected, $json)
    {
        PHPUnit::assertSame($expected, $json);
    }

    /**
     * Asserts that an array of resource objects correspond to a given collection.
     *
     * @param array $expected
     * @param array $json
     */
    public static function assertResourceCollectionEquals($expected, $json)
    {
        static::assertIsArrayOfObjects($json);
        PHPUnit::assertEquals(count($expected), count($json));

        $index = 0;
        foreach ($expected as $resource) {
            static::assertResourceObjectEquals($resource, $json[$index]);
            $index++;
        }
    }
}
