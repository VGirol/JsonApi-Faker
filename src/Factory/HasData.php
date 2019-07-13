<?php

declare(strict_types=1);

namespace VGirol\JsonApiAssert\Factory;

trait HasData
{
    /**
     * Undocumented variable
     *
     * @var ResourceIdentifierFactory|ResourceObjectFactory|CollectionFactory|null
     */
    public $data = null;

    /**
     * Undocumented function
     *
     * @param ResourceIdentifierFactory|ResourceObjectFactory|CollectionFactory|null $data
     * @return static
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
