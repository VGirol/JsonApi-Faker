<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Members;

/**
 * A factory for resource identifier object
 */
class ResourceIdentifierFactory extends BaseFactory
{
    use HasIdentification;
    use HasMeta;

    /**
     * @inheritDoc
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        $resource = [];
        $identification = $this->getIdentification();
        if (!is_null($identification)) {
            $resource = array_merge($resource, $identification);
        }

        if (isset($this->meta)) {
            $resource[Members::META] = $this->meta;
        }

        return $resource;
    }

    /**
     * Fill the resource identifier object with fake values ("type", "id" and "meta").
     *
     * @return static
     */
    public function fake()
    {
        return $this->fakeIdentification()
            ->fakeMeta();
    }
}
