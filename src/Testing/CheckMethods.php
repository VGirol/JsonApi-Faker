<?php

namespace VGirol\JsonApiFaker\Testing;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiFaker\Contract\FactoryContract;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;

/**
 * Add the ability to unit test some usual methods like getter, setter, ...
 */
trait CheckMethods
{
    /**
     * Undocumented function
     *
     * @param FactoryContract $factory
     * @param string          $setter
     * @param string          $getter
     * @param array           $data1
     * @param array           $data2
     *
     * @return void
     * @throws JsonApiFakerException
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    protected function checkAddSingle($factory, string $setter, string $getter, array $data1, array $data2)
    {
        PHPUnit::assertEmpty($factory->{$getter}());

        if (empty($data1)) {
            throw new JsonApiFakerException('You must provide data for first run.');
        }

        foreach ($data1 as $key => $value) {
            $obj = $factory->{$setter}($key, $value);

            PHPUnit::assertSame($obj, $factory);
        }

        PHPUnit::assertEquals($data1, $factory->{$getter}());

        if (empty($data2)) {
            throw new JsonApiFakerException('You must provide data for second run.');
        }

        foreach ($data2 as $key => $value) {
            $factory->{$setter}($key, $value);
        }

        PHPUnit::assertEquals(
            array_merge($data1, $data2),
            $factory->{$getter}()
        );
    }

    /**
     * Undocumented function
     *
     * @param FactoryContract $factory
     * @param string          $setter
     * @param string          $getter
     * @param array           $data1
     * @param array           $data2
     *
     * @return void
     * @throws JsonApiFakerException
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    protected function checkAddMulti($factory, string $setter, string $getter, array $data1, array $data2)
    {
        PHPUnit::assertEmpty($factory->{$getter}());

        $obj = $factory->{$setter}($data1);

        PHPUnit::assertEquals($data1, $factory->{$getter}());
        PHPUnit::assertSame($obj, $factory);

        $factory->{$setter}($data2);

        PHPUnit::assertEquals(
            array_merge($data1, $data2),
            $factory->{$getter}()
        );
    }

    /**
     * Undocumented function
     *
     * @param FactoryContract $factory
     * @param string $setter
     * @param string $getter
     * @param mixed $data1
     * @param mixed $data2
     *
     * @return void
     * @throws \PHPUnit\Framework\AssertionFailedError
     */
    protected function checkSetMethod($factory, string $setter, string $getter, $data1, $data2)
    {
        PHPUnit::assertEmpty($factory->{$getter}());

        $obj = $factory->{$setter}($data1);

        PHPUnit::assertEquals($data1, $factory->{$getter}());
        PHPUnit::assertSame($obj, $factory);

        $factory->{$setter}($data2);

        PHPUnit::assertEquals($data2, $factory->{$getter}());
    }
}
