<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

/**
 * Interface for all factory classes.
 */
interface FactoryContract
{
    /**
     * Exports the factory as an array.
     *
     * @return array<array>|array<string,mixed>|null
     */
    public function toArray(): ?array;

    /**
     * Fill the object with fake values.
     *
     * @return static
     */
    public function fake();

    /**
     * Add a member to an internal object (such as the "attributes" object of a resource).
     *
     * @param string $object
     * @param string $name
     * @param mixed $value
     *
     * @return void
     */
    public function addToObject(string $object, string $name, $value): void;

    /**
     * Add an object to an internal array (such as the "errors" array).
     *
     * @param string $object
     * @param mixed $value
     *
     * @return void
     */
    public function addToArray(string $object, $value): void;

    /**
     * Exports the factory as a JSON string.
     *
     * @param integer $options Bitmask (@see https://www.php.net/manual/en/function.json-encode.php)
     *
     * @return string
     */
    public function toJson($options = 0): string;
}
