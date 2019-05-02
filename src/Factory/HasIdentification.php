<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

use VGirol\JsonApiAssert\Members;

trait HasIdentification
{
    protected $id;

    protected $resourceType;

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setResourceType($resourceType): self
    {
        $this->resourceType = $resourceType;

        return $this;
    }

    protected function getIdentification(): array
    {
        return [
            Members::TYPE => $this->resourceType,
            Members::ID => strval($this->id)
        ];
    }
}
