<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for error object factory.
 */
interface ErrorContract extends
    FactoryContract,
    HasIdentifierContract,
    HasLinksContract,
    HasMetaContract
{
    /**
     * Set one of the following member : status, code, title, details
     *
     * @param string $key
     * @param string $value
     *
     * @return static
     */
    public function set(string $key, string $value);

    /**
     * Set the "source" member
     *
     * @param array $source
     *
     * @return static
     */
    public function setSource(array $source);
}
