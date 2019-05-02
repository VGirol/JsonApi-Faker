<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

abstract class BaseFactory
{
    abstract public function toArray(): array;

    protected function addMemberToObject(string $object, string $name, $value): void
    {
        if (!isset($this->{$object})) {
            $this->{$object} = [];
        }

        $this->{$object}[$name] = $value;
    }

    public static function factory(string $className, array $args = [])
    {
        return new $className(...$args);
    }
}
