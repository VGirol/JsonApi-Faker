<?php

declare(strict_types=1);

namespace VGirol\JsonApiAssert\Factory;

use VGirol\JsonApiAssert\Members;

class DocumentFactory extends BaseFactory
{
    use HasData;
    use HasErrors;
    use HasLinks;
    use HasMeta;

    /**
     * Undocumented variable
     *
     * @var CollectionFactory
     */
    public $included;

    /**
     * Undocumented variable
     *
     * @var JsonapiFactory
     */
    public $jsonapi;

    /**
     * Undocumented function
     *
     * @param CollectionFactory $included
     * @return static
     */
    public function setIncluded($included)
    {
        $this->included = $included;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param JsonapiFactory $jsonapi
     * @return static
     */
    public function setJsonapi($jsonapi)
    {
        $this->jsonapi = $jsonapi;

        return $this;
    }

    public function toArray(): array
    {
        $json = [];

        if (isset($this->meta)) {
            $json[Members::META] = $this->meta;
        }
        if (isset($this->links)) {
            $json[Members::LINKS] = $this->links;
        }
        if (isset($this->errors)) {
            $json[Members::ERRORS] = $this->errors;
        }
        if (isset($this->data)) {
            $json[Members::DATA] = $this->data->toArray();
        }
        if (isset($this->included)) {
            $json[Members::INCLUDED] = $this->included->toArray();
        }
        if (isset($this->jsonapi)) {
            $json[Members::JSONAPI] = $this->jsonapi;
        }

        return $json;
    }
}
