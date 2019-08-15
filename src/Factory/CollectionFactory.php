<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

class CollectionFactory extends BaseFactory
{
    /**
     * Array of ResourceObjectFactory or ResourceIdentifierFactory objects
     *
     * @var array
     */
    public $array;

    /**
     * Undocumented function
     *
     * @param array<ResourceIdentifierFactory>|array<ResourceObjectFactory> $collection
     *
     * @return static
     */
    public function setCollection($collection)
    {
        $this->array = $collection;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return array|null
     */
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

    /**
     * Undocumented function
     *
     * @param callable $callback
     * @return static
     */
    public function each($callback)
    {
        array_walk($this->array, $callback);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param Callable $callback
     *
     * @return array
     */
    public function map($callback): array
    {
        return array_map($callback, $this->array);
    }

    /**
     * Undocumented function
     *
     * @return static
     */
    public function fake($options = null, $count = 5)
    {
        if (is_null($options)) {
            $options = self::FAKE_RESOURCE_OBJECT;
        }
        $class = $options & self::FAKE_RESOURCE_IDENTIFIER ?
            ResourceIdentifierFactory::class : ResourceObjectFactory::class;

        $collection = [];
        for ($i = 0; $i < $count; $i++) {
            $collection[] = (new $class)->fake();
        }

        return $this;
    }
}
