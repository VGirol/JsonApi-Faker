<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for classes having id property.
 */
interface HasIdentifierContract
{
    /**
     * Set the "id" member.
     *
     * @param int|string|null $resourceId
     *
     * @return static
     */
    public function setId($resourceId);

    /**
     * Get the "id" member.
     *
     * @return int|string|null
     */
    public function getId();

    /**
     * Fill the "id" member with a fake value.
     *
     * @return static
     */
    public function fakeIdentifier();
}
