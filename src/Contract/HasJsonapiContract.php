<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for classes having jsonapi property.
 */
interface HasJsonapiContract
{
    /**
     * Sets the jsonapi object.
     *
     * @param JsonapiContract $jsonapi
     *
     * @return static
     */
    public function setJsonapi($jsonapi);

    /**
     * Gets the jsonapi object.
     *
     * @return JsonapiContract
     */
    public function getJsonapi();

    /**
     * Fill the "jsonapi" object with fake members and values.
     *
     * @param integer $countMeta The number of meta members to generate.
     *
     * @return static
     */
    public function fakeJsonapi(int $countMeta = 5);
}
