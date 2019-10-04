<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiConstant\Members;
use VGirol\JsonApiFaker\Contract\ResourceObjectContract;

/**
 * A factory for resource object
 */
class ResourceObjectFactory extends BaseFactory implements ResourceObjectContract
{
    use HasAttributes;
    use HasIdentification;
    use HasLinks;
    use HasMeta;
    use HasRelationships;

    /**
     * Exports the factory as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $resource = [];
        $identification = $this->getIdentification();
        if ($identification !== null) {
            $resource = $identification;
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
                 * @return array
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
