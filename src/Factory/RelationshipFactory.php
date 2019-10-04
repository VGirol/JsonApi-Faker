<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiConstant\Members;
use VGirol\JsonApiFaker\Contract\RelationshipContract;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;

/**
 * A factory for "relationship" object
 */
class RelationshipFactory extends BaseFactory implements RelationshipContract
{
    use HasData;
    use HasLinks;
    use HasMeta;

    /**
     * @return array
     */
    public function toArray(): array
    {
        $resource = [];

        $resource[Members::DATA] = ($this->data === null) ? null : $this->data->toArray();

        if (isset($this->meta)) {
            $resource[Members::META] = $this->meta;
        }
        if (isset($this->links)) {
            $resource[Members::LINKS] = $this->links;
        }

        return $resource;
    }

    /**
     * Fill the relationship with fake values ("data", "meta" and "links").
     *
     * @param integer $options
     * @param integer $count   In case of collection, it represents the number of resource identifier to generate
     *
     * @return static
     * @throws JsonApiFakerException
     */
    public function fake($options = 0, $count = 5)
    {
        if ($options === 0) {
            $options = Options::FAKE_COLLECTION;
        }
        $options |= Options::FAKE_RESOURCE_IDENTIFIER;
        $options &= ~Options::FAKE_RESOURCE_OBJECT;

        return $this->fakeData($options, $count)
            ->fakeMeta()
            ->fakeLinks();
    }
}
