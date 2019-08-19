<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Members;

class ResourceObjectFactory extends BaseFactory
{
    use HasIdentification;
    use HasMeta;
    use HasLinks;
    use HasAttributes;
    use HasRelationships;

    /**
     * Undocumented function
     *
     * @return array
     */
    public function toArray(): array
    {
        $resource = $this->getIdentification();
        if (is_null($resource)) {
            $resource = [];
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
                function ($relationship) {
                    return $relationship->toArray();
                },
                $this->relationships
            );
        }

        return $resource;
    }

    /**
     * Undocumented function
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
