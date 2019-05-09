<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

use VGirol\JsonApiAssert\Members;

class ResourceObjectFactory extends BaseFactory
{
    use HasIdentification;
    use HasMeta;
    use HasLinks;
    use HasRelationships;

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $attributes;

    /**
     * Undocumented function
     *
     * @param array $attributes
     * @return static
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array $attributes
     * @return static
     */
    public function addAttributes(array $attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->addAttribute($name, $value);
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param mixed $value
     * @return static
     */
    public function addAttribute(string $name, $value)
    {
        $this->addMemberToObject('attributes', $name, $value);

        return $this;
    }

    public function toArray(): array
    {
        $resource = $this->getIdentification();

        $resource[Members::ATTRIBUTES] = $this->attributes;

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
}