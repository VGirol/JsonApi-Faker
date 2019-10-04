<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiConstant\Members;

/**
 * Add identification ("type" and "id" members) to a factory.
 */
trait HasIdentification
{
    use HasIdentifier;
    use HasResourceType;

    /**
     * Get the identification ("type" and "id" members) as array
     *
     * @return array|null
     */
    public function getIdentification(): ?array
    {
        if (!isset($this->id) && !isset($this->resourceType)) {
            return null;
        }

        return [
            Members::TYPE => $this->resourceType,
            Members::ID => ($this->id === null) ? null : strval($this->id)
        ];
    }

    /**
     * Fill "type" and "id" members with fake values.
     *
     * @return static
     */
    public function fakeIdentification()
    {
        return $this->fakeResourceType()
            ->fakeIdentifier();
    }
}
