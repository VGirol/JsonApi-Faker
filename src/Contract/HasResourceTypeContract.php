<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for classes having type property.
 */
interface HasResourceTypeContract
{
    /**
     * Set the "type" member.
     *
     * @param string|null $type
     *
     * @return static
     */
    public function setResourceType(?string $type);

    /**
     * Get the "type" member.
     *
     * @return string|null
     */
    public function getResourceType(): ?string;

    /**
     * Fill the "type" member with a fake value.
     *
     * @return static
     */
    public function fakeResourceType();
}
