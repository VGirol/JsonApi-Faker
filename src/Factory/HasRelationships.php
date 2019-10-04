<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Contract\RelationshipContract;

/**
 * Add "relationships" member to a factory.
 */
trait HasRelationships
{
    /**
     * The "relationships" member
     *
     * @var array An array of RelationshipFactory
     */
    protected $relationships;

    /**
     * Get the relationships collection
     *
     * @return array|null
     */
    public function getRelationships(): ?array
    {
        return $this->relationships;
    }

    /**
     * Add a single relationship
     *
     * @param string $name
     * @param RelationshipContract $relationship
     *
     * @return static
     */
    public function addRelationship(string $name, $relationship)
    {
        $this->addToObject('relationships', $name, $relationship);

        return $this;
    }

    /**
     * Fill the "relationships" member with fake values.
     *
     * @param integer $count The number of relationships to generate.
     *
     * @return static
     */
    public function fakeRelationships($count = 2)
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < $count; $i++) {
            $this->addRelationship(
                $faker->unique()->numerify('relationship##'),
                $this->generator->relationship()->fake()
            );
        }

        return $this;
    }
}
