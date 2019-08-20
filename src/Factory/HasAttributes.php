<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

/**
 * Add "attributes" member to a factory.
 */
trait HasAttributes
{
    /**
     * The "attributes" object.
     *
     * @var array<string,mixed>
     */
    public $attributes;

    /**
     * Set all the attributes.
     *
     * @param array<string,mixed> $attributes
     *
     * @return static
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Add many attributes.
     *
     * @param array<string,mixed> $attributes
     *
     * @return static
     */
    public function addAttributes(array $attributes)
    {
        foreach ($attributes as $name => $value) {
            $this->addAttribute($name, $value);
        }

        return $this;
    }

    /**
     * Add a single attribute.
     *
     * @param string $name
     * @param mixed $value
     *
     * @return static
     */
    public function addAttribute(string $name, $value)
    {
        $this->addToObject('attributes', $name, $value);

        return $this;
    }

    /**
     * Fill the "attributes" object with fake members and values.
     *
     * @param integer $count The number of attributes to generate.
     *
     * @return static
     */
    public function fakeAttributes(int $count = 5)
    {
        $this->setAttributes(
            $this->fakeMembers($count)
        );

        return $this;
    }
}
