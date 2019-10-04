<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for all factory classes.
 */
interface FactoryContract
{
    /**
     * Set the Generator instance
     *
     * @param GeneratorContract $generator
     *
     * @return static
     */
    public function setGenerator(GeneratorContract $generator);

    /**
     * Get the Generator instance
     *
     * @return GeneratorContract|null
     */
    public function getGenerator(): ?GeneratorContract;

    /**
     * Exports the factory as an array.
     *
     * @return array|null
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
     * @return static
     */
    public function addToObject(string $object, string $name, $value);

    /**
     * Add an object to an internal array (such as the "errors" array).
     *
     * @param string $object
     * @param mixed $value
     *
     * @return static
     */
    public function addToArray(string $object, $value);

    /**
     * Exports the factory as a JSON string.
     *
     * @param integer $options Bitmask (@see https://www.php.net/manual/en/function.json-encode.php)
     *
     * @return string
     */
    public function toJson($options = 0): string;
}
