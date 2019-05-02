<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

class CollectionFactory extends BaseFactory
{
    /**
     * Undocumented variable
     *
     * @var array<ResourceObjectFactory>|array<ResourceIdentifierFactory>
     */
    protected $collection;

    public function setCollection(array $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    public function toArray(): array
    {
        return $this->map(
            function ($resource) {
                return $resource->toArray();
            },
            $this->collection
        );
    }

    public function each($callback): void
    {
        array_walk($this->collection, $callback);
    }

    public function map($callback): array
    {
        return array_map($callback, $this->collection);
    }
}
