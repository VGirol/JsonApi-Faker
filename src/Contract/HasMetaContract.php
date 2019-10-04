<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for classes having meta property.
 */
interface HasMetaContract
{
    /**
     * Set the "meta" member.
     *
     * @param array $meta
     *
     * @return static
     */
    public function setMeta(array $meta);

    /**
     * Get the "meta" member.
     *
     * @return array|null
     */
    public function getMeta(): ?array;

    /**
     * Add a single value to the "meta" member
     *
     * @param string $name
     * @param mixed $value
     *
     * @return static
     */
    public function addToMeta(string $name, $value);

    /**
     * Fill the "meta" member with fake values.
     *
     * @param integer $count The number of values to generate.
     *
     * @return static
     */
    public function fakeMeta(int $count = 5);
}
