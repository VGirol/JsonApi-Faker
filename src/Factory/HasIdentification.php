<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Members;

/**
 * Add identification ("type" and "id" members) to a factory.
 */
trait HasIdentification
{
    use HasResourceType;
    use HasIdentifier;

    /**
     * Get the identification ("type" and "id" members) as array
     *
     * @return array<string,string>|null
     */
    public function getIdentification()
    {
        if (!isset($this->id) && !isset($this->resourceType)) {
            return null;
        }

        return [
            Members::TYPE => $this->resourceType,
            Members::ID => strval($this->id)
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
