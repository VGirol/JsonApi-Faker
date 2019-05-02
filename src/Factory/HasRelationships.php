<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

trait HasRelationships
{
    protected $relationships;

    public function addRelationship(string $name, $relationship): self
    {
        $this->addMemberToObject('relationships', $name, $relationship);

        return $this;
    }
}
