<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Contract\CollectionContract;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;
use VGirol\JsonApiFaker\Messages;

/**
 * Factory for collection of resource object (@see ResourceObjectFactory)
 * or resource identifier (@see ResourceIdentifierFactory).
 */
class CollectionFactory extends BaseFactory implements CollectionContract
{
    /**
     * Array of objects implementing ResourceObjectContract or ResourceIdentifierContract
     *
     * @var array|null
     */
    protected $array;

    /**
     * Sets the collection.
     *
     * @param array|null $collection An array of objects implementing ResourceObjectContract
     *                               or ResourceIdentifierContract
     *
     * @return static
     */
    public function setCollection($collection)
    {
        $this->array = $collection;

        return $this;
    }

    /**
     * Get the collection.
     *
     * The collection is an array of objects implementing ResourceObjectContract or ResourceIdentifierContract
     *
     * @return array|null
     */
    public function getCollection(): ?array
    {
        return $this->array;
    }

    /**
     * Exports the factory as an array.
     *
     * @return array|null
     * @throws JsonApiFakerException
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
             * @return array|null
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
     * @throws JsonApiFakerException
     */
    public function each($callback)
    {
        if ($this->array === null) {
            throw new JsonApiFakerException(Messages::ERROR_COLLECTION_NOT_SET);
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
     * @throws JsonApiFakerException
     */
    public function map($callback): array
    {
        if ($this->array === null) {
            throw new JsonApiFakerException(Messages::ERROR_COLLECTION_NOT_SET);
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
    public function fake(int $options = 0, int $count = 5)
    {
        if ($options === 0) {
            $options = Options::FAKE_RESOURCE_OBJECT;
        }
        $fn = (($options & Options::FAKE_RESOURCE_IDENTIFIER) == Options::FAKE_RESOURCE_IDENTIFIER) ?
            'resourceIdentifier' : 'resourceObject';

        $collection = [];
        for ($i = 0; $i < $count; $i++) {
            $collection[] = $this->generator->{$fn}()->fake();
        }

        return $this->setCollection($collection);
    }
}
