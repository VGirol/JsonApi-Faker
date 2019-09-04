<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

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
     * Undocumented function
     *
     * @param integer $options Bitmask
     * @param integer $count In case of collection, it represents the number of resource object
     *                       or resource identifier to generate
     *
     * @return static
     */
    public function fakeData($options = null, $count = 3)
    {
        if ($options === null) {
            $options = Options::FAKE_RESOURCE_OBJECT | Options::FAKE_COLLECTION;
            $count = 5;
        }

        $canBeNull = (($options & Options::FAKE_CAN_BE_NULL) == Options::FAKE_CAN_BE_NULL);
        $isCollection = (($options & Options::FAKE_COLLECTION) == Options::FAKE_COLLECTION);
        $isRI = (($options & Options::FAKE_RESOURCE_IDENTIFIER) == Options::FAKE_RESOURCE_IDENTIFIER);

        if ($canBeNull) {
            $faker = \Faker\Factory::create();

            if ($faker->boolean()) {
                $this->setData(null);

                return $this;
            }
        }

        if ($isCollection) {
            $data = (new CollectionFactory)->fake($options, $count);
        } else {
            $data = $isRI ? (new ResourceIdentifierFactory)->fake() : (new ResourceObjectFactory)->fake();
        }
        $this->setData($data);

        return $this;
    }
}
