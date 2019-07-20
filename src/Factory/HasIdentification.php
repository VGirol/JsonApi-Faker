<?php

declare(strict_types=1);

namespace VGirol\JsonApiAssert\Factory;

use VGirol\JsonApiAssert\Members;

trait HasIdentification
{
    use HasResourceType;

    public $id;

    /**
     * Undocumented function
     *
     * @param int|string|null $resourceId
     * @return static
     */
    public function setId($resourceId)
    {
        $this->id = $resourceId;

        return $this;
    }

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
}
