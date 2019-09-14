<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Contract\FactoryContract;

/**
 * Add "data" member to a factory.
 */
trait HasData
{

    /**
     * The "data" member
     *
     * @var ResourceIdentifierFactory|ResourceObjectFactory|CollectionFactory|null
     */
    public $data;

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
     * @param ResourceIdentifierFactory|ResourceObjectFactory|CollectionFactory|null $data
     * @return static
     */
    public function setData($data)
    {
        $this->data = $data;
        $this->hasBeenSet = true;

        return $this;
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
     * @param integer $count In case of collection, it represents the number of resource object
     *                       or resource identifier to generate
     *
     * @return static
     */
    public function fakeData($options = null, int $count = 5)
    {
        if ($options === null) {
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
     * @return FactoryContract
     */
    private function fakeCreateFactoryForData($options, int $count)
    {
        $isCollection = (($options & Options::FAKE_COLLECTION) == Options::FAKE_COLLECTION);
        $isRI = (($options & Options::FAKE_RESOURCE_IDENTIFIER) == Options::FAKE_RESOURCE_IDENTIFIER);

        if ($isCollection) {
            return (new CollectionFactory)->fake($options, $count);
        }

        if ($isRI) {
            return (new ResourceIdentifierFactory)->fake();
        }

        return (new ResourceObjectFactory)->fake();
    }
}
