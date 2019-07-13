<?php

declare(strict_types=1);

namespace VGirol\JsonApiAssert\Factory;

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
     * @return static
     */
    public function addToMeta(string $name, $value)
    {
        $this->addToObject('meta', $name, $value);

        return $this;
    }
}
