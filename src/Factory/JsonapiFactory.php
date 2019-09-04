<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Members;

/**
 * A Factory for the "jsonapi" object.
 */
class JsonapiFactory extends BaseFactory
{
    use HasMeta;
    use HasVersion;

    /**
     * @inheritDoc
     * @return array<string,mixed>|null
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
     * Fill the jsonapi object with fake values ("version" and "meta").
     *
     * @param int $countMeta
     *
     * @return static
     */
    public function fake(int $countMeta = 5)
    {
        return $this->fakeMeta($countMeta)
            ->fakeVersion();
    }
}
