<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

/**
 * Add "version" member to a factory.
 */
trait HasVersion
{
    /**
     * The "version" member
     *
     * @var string
     */
    public $version;

    /**
     * Set the "version" member
     *
     * @param string $version
     *
     * @return static
     */
    public function setVersion(string $version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Fill the "version" member with a fake value.
     *
     * @return static
     */
    public function fakeVersion()
    {
        $faker = \Faker\Factory::create();

        return $this->setVersion(
            $faker->randomDigitNotNull . '.' . $faker->randomDigit
        );
    }
}
