<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Members;

trait HasIdentifier
{
    /**
     * Undocumented variable
     *
     * @var int|string|null
     */
    public $id;

    /**
     * Undocumented function
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
     * Undocumented function
     *
     * @return static
     */
    public function fakeIdentifier()
    {
        $faker = \Faker\Factory::create();

        return $this->setId($faker->randomNumber(2));
    }
}
