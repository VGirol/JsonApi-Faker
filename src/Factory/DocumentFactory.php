<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

class DocumentFactory extends BaseFactory
{
    use HasMeta;
    use HasErrors;
    use HasLinks;

    protected $data;

    protected $included;

    protected $jsonapi;

    public function toArray(): array
    {
        if (isset($this->meta)) {
            $resource[Members::META] = $this->meta;
        }
        if (isset($this->links)) {
            $resource[Members::LINKS] = $this->links;
        }
        if (isset($this->relationships)) {
            // $resource[Members::RELATIONSHIPS] = array_map(
            //     function ($relationship) {
            //         return $relationship->toArray();
            //     },
            //     $this->relationships
            // );
            $resource[Members::RELATIONSHIPS] = $this->relationships;
        }

        return $resource;
    }
}
