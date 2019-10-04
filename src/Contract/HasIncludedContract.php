<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for classes having included property.
 */
interface HasIncludedContract
{
    /**
     * Sets the included collection.
     *
     * @param CollectionContract $included
     *
     * @return static
     */

    public function setIncluded($included);

    /**
     * Gets the included collection.
     *
     * @return CollectionContract $included
     */
    public function getIncluded();
}
