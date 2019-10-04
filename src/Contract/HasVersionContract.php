<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for classes having version property.
 */
interface HasVersionContract
{
    /**
     * Set the "version" member
     *
     * @param string $version
     *
     * @return static
     */
    public function setVersion(string $version);

    /**
     * Get the "version" member
     *
     * @return string|null
     */
    public function getVersion(): ?string;

    /**
     * Fill the "version" member with a fake value.
     *
     * @return static
     */
    public function fakeVersion();
}
