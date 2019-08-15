<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

trait HasVersion
{
    /**
     * Undocumented variable
     *
     * @var string
     */
    public $version;

    /**
     * Undocumented function
     *
     * @param string $version
     * @return static
     */
    public function setVersion(string $version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Undocumented function
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
