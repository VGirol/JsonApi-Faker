<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

use VGirol\JsonApiAssert\Members;

class JsonapiFactory
{
    use HasMeta;

    protected $version;

    public function setVersion($version): self
    {
        $this->version = $version;

        return $this;
    }

    public function toArray(): array
    {
        $json = [];

        if (isset($this->version)) {
            $json[Members::VERSION] = $this->version;
        }
        if (isset($this->meta)) {
            $json[Members::META] = $this->meta;
        }

        return $json;
    }
}
