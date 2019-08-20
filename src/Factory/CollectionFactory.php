<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

/**
 * Factory for collection of resource object (@see ResourceObjectFactory)
 * or resource identifier (@see ResourceIdentifierFactory).
 */
class CollectionFactory extends BaseFactory
{
    /**
     * Array of ResourceObjectFactory or ResourceIdentifierFactory objects
     *
     * @var array<ResourceObjectFactory>|array<ResourceIdentifierFactory>
     */
    public $array;

    /**
     * Sets the collection.
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
     * @inheritDoc
     * @return array<array>|null
     */
    public function toArray(): ?array
    {
        if (!isset($this->array)) {
            return null;
        }

        return $this->map(
            /**
             * @param ResourceObjectFactory|ResourceIdentifierFactory $resource
             *
             * @return array<string,mixed>|null
             */
            function ($resource) {
                return $resource->toArray();
            }
        );
    }

    /**
     * Apply a supplied function to every element of the collection.
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
     * Applies the callback to the elements of the collection.
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
     * Fill the collection with fake values (resource identifers or resource objects).
     *
     * @param integer $options
     * @param integer $count
     *
     * @return static
     */
    public function fake($options = null, $count = 5)
    {
        if (is_null($options)) {
            $options = self::FAKE_RESOURCE_OBJECT;
        }
        $class = (($options & self::FAKE_RESOURCE_IDENTIFIER) == self::FAKE_RESOURCE_IDENTIFIER) ?
            ResourceIdentifierFactory::class : ResourceObjectFactory::class;

        $collection = [];
        for ($i = 0; $i < $count; $i++) {
            $collection[] = (new $class)->fake();
        }

        return $this->setCollection($collection);
    }
}
