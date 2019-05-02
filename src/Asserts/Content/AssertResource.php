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
     * @param array $resource
     */
    public static function assertResourceObjectEquals($expected, $resource)
    {
        PHPUnit::assertSame($expected, $resource);
    }

    /**
     * Asserts that an array of resource objects correspond to a given collection.
     *
     * @param array $expected
     * @param array $collection
     */
    public static function assertResourceCollectionEquals($expected, $collection)
    {
        static::assertIsArrayOfObjects($collection);
        PHPUnit::assertEquals(count($expected), count($collection));

        $index = 0;
        foreach ($expected as $resource) {
            static::assertResourceObjectEquals($resource, $collection[$index]);
            $index++;
        }
    }
}
