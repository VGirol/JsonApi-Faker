<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiConstant\Members;

/**
 * Add "meta" member to a factory.
 */
trait HasMeta
{
    /**
     * The "meta" member
     *
     * @var array
     */
    protected $meta;

    /**
     * Set the "meta" member.
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
     * Get the "meta" member.
     *
     * @return array|null
     */
    public function getMeta(): ?array
    {
        return $this->meta;
    }

    /**
     * Add a single value to the "meta" member
     *
     * @param string $name
     * @param mixed $value
     *
     * @return static
     */
    public function addToMeta(string $name, $value)
    {
        $this->addToObject(Members::META, $name, $value);

        return $this;
    }

    /**
     * Fill the "meta" member with fake values.
     *
     * @param integer $count The number of values to generate.
     *
     * @return static
     */
    public function fakeMeta(int $count = 5)
    {
        $this->setMeta(
            $this->fakeMembers($count)
        );

        return $this;
    }
}
