<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for classes having attributes property.
 */
interface HasIdentificationContract extends HasIdentifierContract, HasResourceTypeContract
{
    /**
     * Get the identification ("type" and "id" members) as array
     *
     * @return array|null
     */
    public function getIdentification(): ?array;

    /**
     * Fill "type" and "id" members with fake values.
     *
     * @return static
     */
    public function fakeIdentification();
}
