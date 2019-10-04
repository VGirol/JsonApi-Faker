<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for CollectionFactory classes.
 */
interface CollectionContract extends FactoryContract
{
    /**
     * Sets the collection.
     *
     * @param array|null $collection An array of objects implementing ResourceObjectContract
     *                               or ResourceIdentifierContract
     *
     * @return static
     */
    public function setCollection($collection);

    /**
     * Get the collection.
     *
     * The collection is an array of objects implementing ResourceObjectContract or ResourceIdentifierContract
     *
     * @return array|null
     */
    public function getCollection(): ?array;

    /**
     * Apply a supplied function to every element of the collection.
     *
     * @param callable $callback
     *
     * @return static
     */
    public function each($callback);

    /**
     * Applies the callback to the elements of the collection.
     *
     * @param Callable $callback
     *
     * @return array
     */
    public function map($callback): array;
}
