<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

use VGirol\JsonApiAssert\Members;

class RelationshipFactory extends BaseFactory
{
    use HasMeta;
    use HasLinks;

    /**
     * Undocumented variable
     *
     * @var ResourceIdentifierFactory|CollectionFactory|null
     */
    protected $data = null;

    /**
     * Undocumented function
     *
     * @param ResourceIdentifierFactory|CollectionFactory|null $data
     * @return static
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function toArray(): array
    {
        $resource = [];

        if (!is_null($this->data)) {
            $resource[Members::DATA] = $this->data->toArray();
        } else {
            $resource[Members::DATA] = $this->data;
        }
        if (isset($this->meta)) {
            $resource[Members::META] = $this->meta;
        }
        if (isset($this->links)) {
            $resource[Members::LINKS] = $this->links;
        }

        return $resource;
    }
}
