<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for classes having attributes property.
 */
interface HasAttributesContract
{
    /**
     * Set all the attributes.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function setAttributes(array $attributes);

    /**
     * Get all the attributes.
     *
     * @return array|null
     */
    public function getAttributes(): ?array;

    /**
     * Add many attributes.
     *
     * @param array $attributes
     *
     * @return static
     */
    public function addAttributes(array $attributes);

    /**
     * Add a single attribute.
     *
     * @param string $name
     * @param mixed $value
     *
     * @return static
     */
    public function addAttribute(string $name, $value);

    /**
     * Fill the "attributes" object with fake members and values.
     *
     * @param integer $count The number of attributes to generate.
     *
     * @return static
     */
    public function fakeAttributes(int $count = 5);
}
