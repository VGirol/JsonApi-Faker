<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiConstant\Members;
use VGirol\JsonApiFaker\Contract\DocumentContract;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;

/**
 * Factory for an entire document.
 */
class DocumentFactory extends BaseFactory implements DocumentContract
{
    use HasData;
    use HasErrors;
    use HasIncluded;
    use HasJsonapi;
    use HasLinks;
    use HasMeta;

    /**
     * @throws JsonApiFakerException
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
            $json[Members::ERRORS] = array_map(
                /**
                 * @param \VGirol\JsonApiFaker\Contract\ErrorContract $error
                 *
                 * @return array|null
                 */
                function ($error) {
                    return $error->toArray();
                },
                $this->errors
            );
        }
        if ($this->dataHasBeenSet()) {
            $json[Members::DATA] = ($this->data === null) ? null : $this->data->toArray();
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
     * Fill the document with fake values (links, meta, jsonapi and errors or data).
     *
     * @param integer $options
     * @param integer $count
     *
     * @return static
     * @throws JsonApiFakerException
     */
    public function fake(int $options = 0, int $count = 3)
    {
        if ($options === 0) {
            $options = Options::FAKE_SINGLE | Options::FAKE_RESOURCE_OBJECT;
        }

        $withErrors = (($options & Options::FAKE_ERRORS) == Options::FAKE_ERRORS);

        $this->fakeLinks()
            ->fakeMeta()
            ->fakeJsonapi();

        return $withErrors ? $this->fakeErrors($count) : $this->fakeData($options, $count);
    }
}
