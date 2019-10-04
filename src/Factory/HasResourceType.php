<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

/**
 * Add "type" member to a factory.
 */
trait HasResourceType
{
    /**
     * The "type" member
     *
     * @var string|null
     */
    protected $resourceType;

    /**
     * Set the "type" member.
     *
     * @param string|null $type
     *
     * @return static
     */
    public function setResourceType(?string $type)
    {
        $this->resourceType = $type;

        return $this;
    }

    /**
     * Get the "type" member.
     *
     * @return string|null
     */
    public function getResourceType(): ?string
    {
        return $this->resourceType;
    }

    /**
     * Fill the "type" member with a fake value.
     *
     * @return static
     */
    public function fakeResourceType()
    {
        $faker = \Faker\Factory::create();

        return $this->setResourceType($faker->word());
    }
}
