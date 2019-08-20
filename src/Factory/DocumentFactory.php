<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Members;

/**
 * Factory for an entire document.
 */
class DocumentFactory extends BaseFactory
{
    use HasData;
    use HasErrors;
    use HasLinks;
    use HasMeta;

    /**
     * The collection of included resources
     *
     * @var CollectionFactory
     */
    public $included;

    /**
     * The jsonapi object
     *
     * @var JsonapiFactory
     */
    public $jsonapi;

    /**
     * Sets the included collection.
     *
     * @param CollectionFactory $included
     *
     * @return static
     */
    public function setIncluded($included)
    {
        $this->included = $included;

        return $this;
    }

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
     * @inheritDoc
     * @return array<string,mixed>
     */
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
        if ($this->dataHasBeenSet()) {
            $json[Members::DATA] = is_null($this->data) ? null : $this->data->toArray();
        }
        if (isset($this->included)) {
            $json[Members::INCLUDED] = $this->included->toArray();
        }
        if (isset($this->jsonapi)) {
            $json[Members::JSONAPI] = $this->jsonapi->toArray();
        }

        return $json;
    }

    /**
     * Undocumented function
     *
     * @param integer $options
     *
     * @return static
     */
    public function fake($options = null, $count = null)
    {
        if (is_null($options)) {
            $options = self::FAKE_SINGLE | self::FAKE_RESOURCE_OBJECT;
        }

        $withErrors = (($options & self::FAKE_ERRORS) == self::FAKE_ERRORS);

        $this->fakeLinks()
            ->fakeMeta()
            ->setJsonapi(new JsonapiFactory)
            ->jsonapi->fake();

        return $withErrors ? $this->fakeErrors($count) : $this->fakeData($options, $count);
    }
}
