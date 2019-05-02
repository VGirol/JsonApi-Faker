<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

trait HasLinks
{
    protected $links;

    public function setLinks(array $links): self
    {
        $this->links = $links;

        return $this;
    }

    public function addLinks(array $links): self
    {
        foreach ($links as $name => $link) {
            $this->addLink($name, $link);
        }

        return $this;
    }

    public function addLink(string $name, $link): self
    {
        $this->addMemberToObject('links', $name, $link);

        return $this;
    }
}
