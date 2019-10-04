<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiConstant\Members;
use VGirol\JsonApiFaker\Contract\ResourceIdentifierContract;

/**
 * A factory for resource identifier object
 */
class ResourceIdentifierFactory extends BaseFactory implements ResourceIdentifierContract
{
    use HasIdentification;
    use HasMeta;

    /**
     * @return array
     */
    public function toArray(): array
    {
        $resource = [];
        $identification = $this->getIdentification();
        if ($identification !== null) {
            $resource = $identification;
        }

        if (isset($this->meta)) {
            $resource[Members::META] = $this->meta;
        }

        return $resource;
    }

    /**
     * Fill the resource identifier object with fake values ("type", "id" and "meta").
     *
     * @return static
     */
    public function fake()
    {
        return $this->fakeIdentification()
            ->fakeMeta();
    }
}
