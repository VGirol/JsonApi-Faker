<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

trait HasMeta
{
    /**
     * Undocumented variable
     *
     * @var array
     */
    public $meta;

    /**
     * Undocumented function
     *
     * @param array $meta
     *
     * @return static
     */
    public function setMeta(array $meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param mixed $value
     *
     * @return static
     */
    public function addToMeta(string $name, $value)
    {
        $this->addToObject('meta', $name, $value);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param integer $count
     *
     * @return static
     */
    public function fakeMeta($count = 5)
    {
        $this->setMeta(
            $this->fakeMembers($count)
        );

        return $this;
    }

    protected function fakeMetaIf($options = null, $count = 5)
    {
        if ($options & self::FAKE_NO_META) {
            return $this;
        }

        $faker = \Faker\Factory::create();
        if (($options & self::FAKE_RANDOM_META) && ($faker->boolean === false)) {
            return $this;
        }

        return $this->fakeMeta($count);
    }
}
