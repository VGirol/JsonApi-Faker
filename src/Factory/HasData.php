<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

trait HasData
{

    /**
     * Undocumented variable
     *
     * @var ResourceIdentifierFactory|ResourceObjectFactory|CollectionFactory|null
     */
    public $data = null;

    /**
     * Undocumented function
     *
     * @param ResourceIdentifierFactory|ResourceObjectFactory|CollectionFactory|null $data
     * @return static
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return static
     */
    public function fakeData($options = null, $count = null)
    {
        if (is_null($options)) {
            $options = self::FAKE_RESOURCE_OBJECT | self::FAKE_COLLECTION | self::FAKE_CAN_BE_NULL;
            $count = 5;
        }

        $faker = \Faker\Factory::create();

        if ($options & self::FAKE_CAN_BE_NULL) {
            if ($faker->boolean === true) {
                $this->setData(null);
                return $this;
            }
        }

        $class = $options & self::FAKE_RESOURCE_IDENTIFIER ?
            ResourceIdentifierFactory::class : ResourceObjectFactory::class;

        if ($options & self::FAKE_COLLECTION) {
            $data = (new CollectionFactory)->fake($count);
        } else {
            $data = (new $class)->fake();
        }
        $this->setData($data);

        return $this;
    }
}
