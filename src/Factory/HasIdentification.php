<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

use VGirol\JsonApiAssert\Members;

trait HasIdentification
{
    protected $id;

    protected $resourceType;

    /**
     * Undocumented function
     *
     * @param int|string|null $id
     * @return static
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string|null $resourceType
     * @return static
     */
    public function setResourceType(?string $resourceType)
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    protected function getIdentification(): ?array
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
