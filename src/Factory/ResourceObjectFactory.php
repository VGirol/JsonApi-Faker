<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

use VGirol\JsonApiAssert\Members;

class ResourceObjectFactory extends BaseFactory
{
    use HasIdentification;
    use HasMeta;
    use HasLinks;

    protected $attributes;

    protected $relationships;

    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function addAttributes(array $attributes): self
    {
        foreach ($attributes as $name => $value) {
            $this->addAttribute($name, $value);
        }

        return $this;
    }

    public function addAttribute(string $name, $value): self
    {
        $this->addMemberToObject('attributes', $name, $value);

        return $this;
    }

    public function addRelationship(string $name, $relationship): self
    {
        $this->addMemberToObject('relationships', $name, $relationship);

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
