<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

/**
 * Add "jsonapi" member to a factory.
 */
trait HasJsonapi
{
    /**
     * The jsonapi object
     *
     * @var JsonapiFactory
     */
    public $jsonapi;

    /**
     * Sets the jsonapi object.
     *
     * @param JsonapiFactory $jsonapi
     *
     * @return static
     */
    public function setJsonapi($jsonapi)
    {
        $this->jsonapi = $jsonapi;

        return $this;
    }

    /**
     * Fill the "jsonapi" object with fake members and values.
     *
     * @param integer $countMeta The number of meta members to generate.
     *
     * @return static
     */
    public function fakeJsonapi(int $countMeta = 5)
    {
        return $this->setJsonapi((new JsonapiFactory)->fake($countMeta));
    }
}
