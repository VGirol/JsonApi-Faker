<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

/**
 * Add "included" member to a factory.
 */
trait HasIncluded
{
    /**
     * The collection of included resources
     *
     * @var CollectionFactory
     */
    public $included;

    /**
     * Sets the included collection.
     *
     * @param CollectionFactory $included
     *
     * @return static
     */
    public function setIncluded($included)
    {
        $this->included = $included;

        return $this;
    }
}
