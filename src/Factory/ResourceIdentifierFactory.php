<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Members;

class ResourceIdentifierFactory extends BaseFactory
{
    use HasIdentification;
    use HasMeta;

    /**
     * Undocumented function
     *
     * @return array|null
     */
    public function toArray(): ?array
    {
        $resource = $this->getIdentification();

        if (isset($this->meta)) {
            $resource[Members::META] = $this->meta;
        }

        return $resource;
    }

    /**
     * Undocumented function
     *
     * @return static
     */
    public function fake()
    {
        return $this->fakeIdentification()
            ->fakeMeta();
    }
}
