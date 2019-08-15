<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Members;

class JsonapiFactory extends BaseFactory
{
    use HasMeta;
    use HasVersion;

    /**
     * Undocumented function
     *
     * @return array|null
     */
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

    /**
     * Undocumented function
     *
     * @return static
     */
    public function fake()
    {
        return $this->fakeMeta()
            ->fakeVersion();
    }
}
