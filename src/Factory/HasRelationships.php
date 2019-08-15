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
     * @return static
     */
    public function fakeRelationships()
    {
        $faker = \Faker\Factory::create();

        return $this->addRelationship(
            $faker->word,
            (new RelationshipFactory)->fake()
        );
    }
}
