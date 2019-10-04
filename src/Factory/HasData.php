<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Contract\CollectionContract;
use VGirol\JsonApiFaker\Contract\ResourceIdentifierContract;
use VGirol\JsonApiFaker\Contract\ResourceObjectContract;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;
use VGirol\JsonApiFaker\Messages;

/**
 * Add "data" member to a factory.
 */
trait HasData
{
    /**
     * The "data" member
     *
     * @var ResourceIdentifierContract|ResourceObjectContract|CollectionContract|null
     */
    protected $data;

    /**
     * Flag to indicate that "data" member has been set.
     * This can distinguish "data" member set to null to unset "data" member.
     *
     * @var boolean
     */
    private $hasBeenSet = false;

    /**
     * Set "data" member
     *
     * @param ResourceIdentifierContract|ResourceObjectContract|CollectionContract|null $data
     *
     * @return static
     * @throws JsonApiFakerException
     */
    public function setData($data)
    {
        if (($data !== null)
            && (is_a($data, ResourceIdentifierContract::class) === false)
            && (is_a($data, ResourceObjectContract::class) === false)
            && (is_a($data, CollectionContract::class) === false)
            ) {
            throw new JsonApiFakerException(Messages::SET_DATA_BAD_TYPE);
        }

        $this->data = $data;
        $this->hasBeenSet = true;

        return $this;
    }

    /**
     * Get "data" member
     *
     * @return ResourceIdentifierContract|ResourceObjectContract|CollectionContract|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Check if the "data" member has been set.
     *
     * @return boolean
     */
    public function dataHasBeenSet(): bool
    {
        return $this->hasBeenSet;
    }

    /**
     * Fill the "data" member with fake values
     *
     * @param integer $options Bitmask
     * @param integer $count   In case of collection, it represents the number of resource object
     *                         or resource identifier to generate
     *
     * @return static
     * @throws JsonApiFakerException
     */
    public function fakeData(int $options = 0, int $count = 5)
    {
        if ($options === 0) {
            $options = Options::FAKE_RESOURCE_OBJECT | Options::FAKE_COLLECTION;
        }

        $canBeNull = (($options & Options::FAKE_CAN_BE_NULL) == Options::FAKE_CAN_BE_NULL);

        if ($canBeNull) {
            $faker = \Faker\Factory::create();

            if ($faker->boolean()) {
                $this->setData(null);

                return $this;
            }
        }

        $dataFactory = $this->fakeCreateFactoryForData($options, $count);
        $this->setData($dataFactory);

        return $this;
    }

    /**
     * Get the factory used to fill the "data" member when creating fake values
     *
     * @param integer $options Bitmask
     * @param integer $count In case of collection, it represents the number of resource object
     *                       or resource identifier to generate
     *
     * @return ResourceIdentifierContract|ResourceObjectContract|CollectionContract
     */
    private function fakeCreateFactoryForData(int $options, int $count)
    {
        $isCollection = (($options & Options::FAKE_COLLECTION) == Options::FAKE_COLLECTION);
        $isRI = (($options & Options::FAKE_RESOURCE_IDENTIFIER) == Options::FAKE_RESOURCE_IDENTIFIER);

        if ($isCollection) {
            return $this->generator
                ->collection()
                ->fake($options, $count);
        }

        if ($isRI) {
            return $this->generator
                ->resourceIdentifier()
                ->fake();
        }

        return $this->generator
            ->resourceObject()
            ->fake();
    }
}
