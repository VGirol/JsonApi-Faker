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
            'getVersion',
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

        PHPUnit::assertEmpty($mock->getVersion());

        $obj = $mock->fakeVersion();

        PHPUnit::assertSame($obj, $mock);
        PHPUnit::assertNotEmpty($mock->getVersion());
        PHPUnit::assertIsString($mock->getVersion());

        PHPUnit::assertMatchesRegularExpression('/[1-9]\.[0-9]/', $mock->getVersion());
    }
}
