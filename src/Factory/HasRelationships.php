<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

trait HasRelationships
{
    /**
     * Undocumented variable
     *
     * @var array<string, RelationshipFactory>
     */
    protected $relationships;

    /**
     * Undocumented function
     *
     * @param string $name
     * @param RelationshipFactory $relationship
     * @return static
     */
    public function addRelationship(string $name, $relationship)
    {
        $this->addToObject('relationships', $name, $relationship);

        return $this;
    }
}
