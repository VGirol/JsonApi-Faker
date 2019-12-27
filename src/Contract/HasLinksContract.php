<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

use VGirol\JsonApiConstant\Members;

/**
 * Interface for classes having links property.
 */
interface HasLinksContract
{
    /**
     * Set the "links" member.
     *
     * @param array $links
     *
     * @return static
     */
    public function setLinks(array $links);

    /**
     * Set the "links" member.
     *
     * @return array|null
     */
    public function getLinks(): ?array;

    /**
     * Add some links to the "links" member.
     *
     * @param array $links
     *
     * @return static
     */
    public function addLinks(array $links);

    /**
     * Add a single link to the "links" member
     *
     * @param string $name
     * @param array|string|null $link
     *
     * @return static
     */
    public function addLink(string $name, $link);

    /**
     * Fill the "links" member with fake values.
     *
     * @param array $links
     *
     * @return static
     */
    public function fakeLinks($links = [Members::LINK_SELF => ['url']]);
}
