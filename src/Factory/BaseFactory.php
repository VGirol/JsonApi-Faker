<?php

declare(strict_types=1);

namespace VGirol\JsonApiAssert\Factory;

abstract class BaseFactory
{
    abstract public function toArray(): ?array;

    public function addToObject(string $object, string $name, $value): void
    {
        if (!isset($this->{$object})) {
            $this->{$object} = [];
        }

        $this->{$object}[$name] = $value;
    }

    public function addToArray(string $object, $value): void
    {
        if (!isset($this->{$object})) {
            $this->{$object} = [];
        }

        $this->{$object}[] = $value;
    }
}
