<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Members;

/**
 * A factory for "relationship" object
 */
class RelationshipFactory extends BaseFactory
{
    use HasMeta;
    use HasLinks;
    use HasData;

    /**
     * @inheritDoc
     * @return array<string,mixed>
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
     * @param integer $count In case of collection, it represents the number of resource identifier to generate
     *
     * @return static
     */
    public function fake($options = null, $count = 5)
    {
        if ($options === null) {
            $options = Options::FAKE_COLLECTION;
        }
        $options |= Options::FAKE_RESOURCE_IDENTIFIER;
        $options &= ~Options::FAKE_RESOURCE_OBJECT;

        return $this->fakeData($options, $count)
            ->fakeMeta()
            ->fakeLinks();
    }
}
