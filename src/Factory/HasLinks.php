<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

trait HasLinks
{
    protected $links;

    /**
     * Undocumented function
     *
     * @param array $links
     * @return static
     */
    public function setLinks(array $links)
    {
        $this->links = $links;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array $links
     * @return static
     */
    public function addLinks(array $links)
    {
        foreach ($links as $name => $link) {
            $this->addLink($name, $link);
        }

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param array|string|null $link
     * @return static
     */
    public function addLink(string $name, $link)
    {
        $this->addToObject('links', $name, $link);

        return $this;
    }
}