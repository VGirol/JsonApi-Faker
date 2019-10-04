<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiConstant\Members;
use VGirol\JsonApiFaker\Contract\JsonapiContract;

/**
 * A Factory for the "jsonapi" object.
 */
class JsonapiFactory extends BaseFactory implements JsonapiContract
{
    use HasMeta;
    use HasVersion;

    /**
     * @return array|null
     */
    public function toArray(): ?array
    {
        $json = [];

        if (isset($this->version)) {
            $json[Members::JSONAPI_VERSION] = $this->version;
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
