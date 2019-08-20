<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

/**
 * Add "id" member to a factory
 */
trait HasIdentifier
{
    /**
     * "id" member"
     *
     * @var int|string|null
     */
    public $id;

    /**
     * Set the "id" member.
     *
     * @param int|string|null $resourceId
     * @return static
     */
    public function setId($resourceId)
    {
        $this->id = $resourceId;

        return $this;
    }

    /**
     * Fill the "id" member with a fake value.
     *
     * @return static
     */
    public function fakeIdentifier()
    {
        $faker = \Faker\Factory::create();

        return $this->setId($faker->numberBetween(1, 100));
    }
}
