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
     * @var array<ResourceObjectFactory>|array<ResourceIdentifierFactory>|null
     */
    public $array;

    /**
     * Sets the collection.
     *
     * @param array<ResourceIdentifierFactory>|array<ResourceObjectFactory>|null $collection
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
     *
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
     *
     * @return static
     * @throws \Exception
     */
    public function each($callback)
    {
        if ($this->array === null) {
            throw new \Exception('The collection is not set.');
        }
        array_walk($this->array, $callback);

        return $this;
    }

    /**
     * Applies the callback to the elements of the collection.
     *
     * @param Callable $callback
     *
     * @return array
     * @throws \Exception
     */
    public function map($callback): array
    {
        if ($this->array === null) {
            throw new \Exception('The collection is not set.');
        }

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
        if ($options === null) {
            $options = Options::FAKE_RESOURCE_OBJECT;
        }
        $class = (($options & Options::FAKE_RESOURCE_IDENTIFIER) == Options::FAKE_RESOURCE_IDENTIFIER) ?
            ResourceIdentifierFactory::class : ResourceObjectFactory::class;

        $collection = [];
        for ($i = 0; $i < $count; $i++) {
            $collection[] = (new $class)->fake();
        }

        return $this->setCollection($collection);
    }
}
