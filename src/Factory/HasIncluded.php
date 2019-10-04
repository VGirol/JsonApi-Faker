<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Contract\CollectionContract;

/**
 * Add "included" member to a factory.
 */
trait HasIncluded
{
    /**
     * The collection of included resources
     *
     * @var CollectionContract
     */
    protected $included;

    /**
     * Sets the included collection.
     *
     * @param CollectionContract $included
     *
     * @return static
     */
    public function setIncluded($included)
    {
        $this->included = $included;

        return $this;
    }

    /**
     * Gets the included collection.
     *
     * @return CollectionContract $included
     */
    public function getIncluded()
    {
        return $this->included;
    }
}
