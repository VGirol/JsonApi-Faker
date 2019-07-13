<?php

declare(strict_types=1);

namespace VGirol\JsonApiAssert\Factory;

trait HasResourceType
{
    /**
     * Undocumented variable
     *
     * @var string
     */
    public $resourceType;

    /**
     * Undocumented function
     *
     * @param string|null $type
     * @return static
     */
    public function setResourceType(?string $type)
    {
        $this->resourceType = $type;

        return $this;
    }
}
