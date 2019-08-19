<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

trait HasRelationships
{
    /**
     * Undocumented variable
     *
     * @var array<string, RelationshipFactory>
     */
    public $relationships;

    /**
     * Undocumented function
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
     * Undocumented function
     *
     * @param integer $count
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
