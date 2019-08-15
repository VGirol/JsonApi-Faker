<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

trait HasAttributes
{
    /**
     * Undocumented variable
     *
     * @var array
     */
    public $attributes;

    /**
     * Undocumented function
     *
     * @param array $attributes
     *
     * @return static
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array $attributes
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
     * Undocumented function
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
     * Undocumented function
     *
     * @param integer $count
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
