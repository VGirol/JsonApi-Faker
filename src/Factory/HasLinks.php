<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

trait HasLinks
{
    public $links;

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

    /**
     * Undocumented function
     *
     * @param array $keys
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

    protected function fakeLinksIf($options = null, $links = ['self' => ['url']])
    {
        if ($options & self::FAKE_NO_LINKS) {
            return $this;
        }

        $faker = \Faker\Factory::create();
        if (($options & self::FAKE_RANDOM_LINKS) && ($faker->boolean === false)) {
            return $this;
        }

        return $this->fakeLinks($links);
    }
}
