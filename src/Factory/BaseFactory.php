<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

abstract class BaseFactory
{
    abstract public function toArray(): ?array;

    protected function addToObject(string $object, string $name, $value): void
    {
        if (!isset($this->{$object})) {
            $this->{$object} = [];
        }

        $this->{$object}[$name] = $value;
    }

    protected function addToArray(string $object, $value): void
    {
        if (!isset($this->{$object})) {
            $this->{$object} = [];
        }

        $this->{$object}[] = $value;
    }
}
