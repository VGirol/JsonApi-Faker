<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for classes having data property.
 */
interface HasDataContract
{
    /**
     * Set "data" member
     *
     * @param ResourceIdentifierContract|ResourceObjectContract|CollectionContract|null $data
     *
     * @return static
     */
    public function setData($data);

    /**
     * Get "data" member
     *
     * @return ResourceIdentifierContract|ResourceObjectContract|CollectionContract|null
     */
    public function getData();

    /**
     * Check if the "data" member has been set.
     *
     * @return boolean
     */
    public function dataHasBeenSet(): bool;

    /**
     * Fill the "data" member with fake values
     *
     * @param integer $options Bitmask
     * @param integer $count   In case of collection, it represents the number of resource object
     *                         or resource identifier to generate
     *
     * @return static
     */
    public function fakeData(int $options = 0, int $count = 5);
}
