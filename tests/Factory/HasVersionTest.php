<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use PHPUnit\Framework\Assert as PHPUnit;
use VGirol\JsonApiFaker\Factory\HasVersion;
use VGirol\JsonApiFaker\Testing\CheckMethods;
use VGirol\JsonApiFaker\Tests\TestCase;

class HasVersionTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function setVersion()
    {
        $this->checkSetMethod(
            $this->getMockForTrait(HasVersion::class),
            'setVersion',
            'version',
            'version1',
            'version2'
        );
    }

    /**
     * @test
     */
    public function fakeAttributes()
    {
        $mock = $this->getMockForTrait(HasVersion::class);

        PHPUnit::assertEmpty($mock->version);

        $obj = $mock->fakeVersion();

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->version);
        PHPUnit::assertIsString($mock->version);

        PHPUnit::assertRegExp('/[1-9]\.[0-9]/', $mock->version);
    }
}
