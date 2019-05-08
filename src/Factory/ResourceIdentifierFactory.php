<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

use VGirol\JsonApiAssert\Members;

class ResourceIdentifierFactory extends BaseFactory
{
    use HasIdentification;
    use HasMeta;

    public function toArray(): ?array
    {
        $resource = $this->getIdentification();

        if (isset($this->meta)) {
            $resource[Members::META] = $this->meta;
        }

        return $resource;
    }
}
