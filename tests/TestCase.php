<?php

namespace VGirol\JsonApiAssert\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use VGirol\JsonApiAssert\Tests\SetExceptionsTrait;

abstract class TestCase extends BaseTestCase
{
    use SetExceptionsTrait;
}
