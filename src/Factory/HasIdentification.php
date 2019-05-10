<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

use VGirol\JsonApiAssert\Members;

trait HasIdentification
{
    use HasResourceType;

    protected $id;

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
