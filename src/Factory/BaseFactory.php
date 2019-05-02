<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

use VGirol\JsonApiAssert\Laravel\Factory\HelperFactory;

abstract class BaseFactory
{
    abstract public function toArray(): array;

    public static function create(...$args): self
    {
        return new static(...$args);
    }

    protected function helper()
    {
        return new HelperFactory;
    }

    protected function addMemberToObject(string $object, string $name, $value): void
    {
        if (!isset($this->{$object})) {
            $this->{$object} = [];
        }

        $this->{$object}[$name] = $value;
    }
}
