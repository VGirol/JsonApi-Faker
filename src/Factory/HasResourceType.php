<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

trait HasResourceType
{
    /**
     * Undocumented variable
     *
     * @var string|null
     */
    public $resourceType;

    /**
     * Undocumented function
     *
     * @param string|null $type
     * @return static
     */
    public function setResourceType(?string $type)
    {
        $this->resourceType = $type;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return static
     */
    public function fakeResourceType()
    {
        $faker = \Faker\Factory::create();

        return $this->setResourceType($faker->word);
    }
}
