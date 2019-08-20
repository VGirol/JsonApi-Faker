<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Members;

/**
 * A factory for resource object
 */
class ResourceObjectFactory extends BaseFactory
{
    use HasIdentification;
    use HasMeta;
    use HasLinks;
    use HasAttributes;
    use HasRelationships;

    /**
     * @inheritDoc
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        $resource = [];
        $identification = $this->getIdentification();
        if (!is_null($identification)) {
            $resource = array_merge($resource, $identification);
        }

        if (isset($this->attributes)) {
            $resource[Members::ATTRIBUTES] = $this->attributes;
        }
        if (isset($this->meta)) {
            $resource[Members::META] = $this->meta;
        }
        if (isset($this->links)) {
            $resource[Members::LINKS] = $this->links;
        }
        if (isset($this->relationships)) {
            $resource[Members::RELATIONSHIPS] = array_map(
                /**
                 * @param RelationshipFactory $relationship
                 * @return array<string,mixed>
                 */
                function ($relationship) {
                    return $relationship->toArray();
                },
                $this->relationships
            );
        }

        return $resource;
    }

    /**
     * Fill the resource object with fake values ("type", "id", "attributes", "meta", "links" and "relationships").
     *
     * @return static
     */
    public function fake()
    {
        return $this->fakeIdentification()
            ->fakeAttributes()
            ->fakeMeta()
            ->fakeLinks()
            ->fakeRelationships();
    }
}
