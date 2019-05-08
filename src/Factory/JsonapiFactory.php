<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

use VGirol\JsonApiAssert\Members;

class JsonapiFactory extends BaseFactory
{
    use HasMeta;

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $version;

    /**
     * Undocumented function
     *
     * @param string $version
     * @return static
     */
    public function setVersion(string $version)
    {
        $this->version = $version;

        return $this;
    }

    public function toArray(): ?array
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
