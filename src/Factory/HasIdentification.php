<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Members;

trait HasIdentification
{
    use HasResourceType;
    use HasIdentifier;

    /**
     * Undocumented function
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
            Members::ID => strval($this->id)
        ];
    }

    /**
     * Undocumented function
     *
     * @return static
     */
    public function fakeIdentification()
    {
        return $this->fakeResourceType()
            ->fakeIdentifier();
    }
}
