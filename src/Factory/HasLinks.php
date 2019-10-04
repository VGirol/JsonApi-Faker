<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

/**
 * Add "links" member to a factory.
 */
trait HasLinks
{
    /**
     * The "links" member
     *
     * @var array
     */
    protected $links;

    /**
     * Set the "links" member.
     *
     * @param array $links
     *
     * @return static
     */
    public function setLinks(array $links)
    {
        $this->links = $links;

        return $this;
    }

    /**
     * Set the "links" member.
     *
     * @return array|null
     */
    public function getLinks(): ?array
    {
        return $this->links;
    }

    /**
     * Add some links to the "links" member.
     *
     * @param array $links
     *
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
     * Add a single link to the "links" member
     *
     * @param string $name
     * @param array|string|null $link
     *
     * @return static
     */
    public function addLink(string $name, $link)
    {
        $this->addToObject('links', $name, $link);

        return $this;
    }

    /**
     * Fill the "links" member with fake values.
     *
     * @param array $links
     *
     * @return static
     */
    public function fakeLinks($links = ['self' => ['url']])
    {
        $this->setLinks(
            $this->fakeMembers($links)
        );

        return $this;
    }
}
