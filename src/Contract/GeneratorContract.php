<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * This class is an helper to generate factories.
 */
interface GeneratorContract
{
    /**
     * Set a factory
     *
     * @param string $key
     * @param string|null $class
     *
     * @return static
     */
    public function setFactory(string $key, ?string $class);

    /**
     * Create a factory
     *
     * @param string $alias
     * @param mixed ...$args
     *
     * @return FactoryContract
     */
    public function create(string $alias, ...$args);

    /**
     * Create a collection factory
     *
     * @param mixed ...$args
     *
     * @return FactoryContract
     */
    public function collection(...$args);

    /**
     * Create a document factory
     *
     * @param mixed ...$args
     *
     * @return FactoryContract
     */
    public function document(...$args);

    /**
     * Create an error factory
     *
     * @param mixed ...$args
     *
     * @return FactoryContract
     */
    public function error(...$args);

    /**
     * Create a jsonapi object factory
     *
     * @param mixed ...$args
     *
     * @return FactoryContract
     */
    public function jsonapiObject(...$args);

    /**
     * Create a relationship object factory
     *
     * @param mixed ...$args
     *
     * @return FactoryContract
     */
    public function relationship(...$args);

    /**
     * Create a resource identifier factory
     *
     * @param mixed ...$args
     *
     * @return FactoryContract
     */
    public function resourceIdentifier(...$args);

    /**
     * Create a resource object factory
     *
     * @param mixed ...$args
     *
     * @return FactoryContract
     */
    public function resourceObject(...$args);
}
