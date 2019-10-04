<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for classes having relationships property.
 */
interface HasRelationshipsContract
{
    /**
     * Add a single relationship
     *
     * @param string $name
     * @param RelationshipContract $relationship
     *
     * @return static
     */
    public function addRelationship(string $name, $relationship);

    /**
     * Get the relationships collection
     *
     * @return array|null
     */
    public function getRelationships(): ?array;

    /**
     * Fill the "relationships" member with fake values.
     *
     * @param integer $count The number of relationships to generate.
     *
     * @return static
     */
    public function fakeRelationships($count = 2);
}
