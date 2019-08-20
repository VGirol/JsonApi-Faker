<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

/**
 * Add "relationships" member to a factory.
 */
trait HasRelationships
{
    /**
     * The "relationships" member
     *
     * @var array<string, RelationshipFactory>
     */
    public $relationships;

    /**
     * Add a single relationship
     *
     * @param string $name
     * @param RelationshipFactory $relationship
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
                (new RelationshipFactory)->fake()
            );
        }

        return $this;
    }
}
