<?php

namespace VGirol\JsonApiAssert\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;

trait CheckMethods
{
    protected function checkSetMethod($factory, string $fnName, string $attrName, $data1, $data2)
    {
        PHPUnit::assertEmpty($factory->{$attrName});

        $obj = $factory->{$fnName}($data1);

        PHPUnit::assertObjectHasAttribute($attrName, $factory);
        PHPUnit::assertEquals($data1, $factory->{$attrName});
        PHPUnit::assertSame($obj, $factory);

        $factory->{$fnName}($data2);

        PHPUnit::assertEquals($data2, $factory->{$attrName});
    }

    public function checkAddSingle($factory, string $fnName, string $attrName, array $data1, array $data2)
    {
        PHPUnit::assertEmpty($factory->{$attrName});

        foreach ($data1 as $key => $value) {
            $obj = $factory->{$fnName}($key, $value);
        }

        PHPUnit::assertObjectHasAttribute($attrName, $factory);
        PHPUnit::assertEquals($data1, $factory->{$attrName});
        PHPUnit::assertSame($obj, $factory);

        foreach ($data2 as $key => $value) {
            $obj = $factory->{$fnName}($key, $value);
        }

        PHPUnit::assertEquals(
            array_merge($data1, $data2),
            $factory->{$attrName}
        );
    }

    public function checkAddMulti($factory, string $fnName, string $attrName, array $data1, array $data2)
    {
        PHPUnit::assertEmpty($factory->{$attrName});

        $obj = $factory->{$fnName}($data1);

        PHPUnit::assertObjectHasAttribute($attrName, $factory);
        PHPUnit::assertEquals($data1, $factory->{$attrName});
        PHPUnit::assertSame($obj, $factory);

        $obj = $factory->{$fnName}($data2);

        PHPUnit::assertEquals(
            array_merge($data1, $data2),
            $factory->{$attrName}
        );
    }
}
