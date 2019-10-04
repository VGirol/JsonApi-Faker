<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Contract\JsonapiContract;

/**
 * Add "jsonapi" member to a factory.
 */
trait HasJsonapi
{
    /**
     * The jsonapi object
     *
     * @var JsonapiContract
     */
    protected $jsonapi;

    /**
     * Sets the jsonapi object.
     *
     * @param JsonapiContract $jsonapi
     *
     * @return static
     */
    public function setJsonapi($jsonapi)
    {
        $this->jsonapi = $jsonapi;

        return $this;
    }

    /**
     * Gets the jsonapi object.
     *
     * @return JsonapiContract
     */
    public function getJsonapi()
    {
        return $this->jsonapi;
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
        return $this->setJsonapi(
            $this->generator
                ->jsonapiObject()
                ->fake($countMeta)
        );
    }
}
