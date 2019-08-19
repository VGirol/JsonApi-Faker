<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Members;

class RelationshipFactory extends BaseFactory
{
    use HasMeta;
    use HasLinks;
    use HasData;

    /**
     * Undocumented function
     *
     * @return array
     */
    public function toArray(): array
    {
        $resource = [];

        $resource[Members::DATA] = is_null($this->data) ? $this->data : $this->data->toArray();

        if (isset($this->meta)) {
            $resource[Members::META] = $this->meta;
        }
        if (isset($this->links)) {
            $resource[Members::LINKS] = $this->links;
        }

        return $resource;
    }

    /**
     * Undocumented function
     *
     * @param integer $options
     * @param integer $count
     *
     * @return static
     */
    public function fake($options = null, $count = 5)
    {
        if (is_null($options)) {
            $options = self::FAKE_COLLECTION;
        }
        $options |= self::FAKE_RESOURCE_IDENTIFIER;
        $options &= ~self::FAKE_RESOURCE_OBJECT;

        return $this->fakeData($options, $count)
            ->fakeMeta()
            ->fakeLinks();
    }
}
