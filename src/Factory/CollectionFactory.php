<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

class CollectionFactory extends BaseFactory
{
    /**
     * Array of ResourceObjectFactory or ResourceIdentifierFactory objects
     *
     * @var array
     */
    protected $array;

    /**
     * Undocumented function
     *
     * @param array<ResourceObjectFactory>|array<ResourceObjectFactory> $collection
     * @return static
     */
    public function setCollection($collection)
    {
        $this->array = $collection;

        return $this;
    }

    public function toArray(): ?array
    {
        if (!isset($this->array)) {
            return null;
        }

        return $this->map(
            function ($resource) {
                return $resource->toArray();
            }
        );
    }

    public function each($callback): void
    {
        array_walk($this->array, $callback);
    }

    public function map($callback): array
    {
        return array_map($callback, $this->array);
    }
}
