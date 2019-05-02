<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

trait HasMeta
{
    protected $meta;

    public function setMeta($meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function addMemberToMeta(string $name, $value): self
    {
        $this->addMemberToObject('meta', $name, $value);

        return $this;
    }
}
