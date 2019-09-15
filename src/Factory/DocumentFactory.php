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
    use HasJsonapi;
    use HasIncluded;

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
     * Undocumented function
     *
     * @param integer|null $options
     * @param integer|null $count
     *
     * @return static
     */
    public function fake($options = null, $count = 3)
    {
        if ($options === null) {
            $options = Options::FAKE_SINGLE | Options::FAKE_RESOURCE_OBJECT;
        }

        $withErrors = (($options & Options::FAKE_ERRORS) == Options::FAKE_ERRORS);

        $this->fakeLinks()
            ->fakeMeta()
            ->fakeJsonapi();

        return $withErrors ? $this->fakeErrors($count) : $this->fakeData($options, $count);
    }
}
