<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use Faker\Generator;
use VGirol\JsonApiFaker\Messages;

/**
 * This class implements some methods of the FactoryContract interface.
 */
abstract class BaseFactory implements FactoryContract
{
    const FAKE_RESOURCE_OBJECT = 1;
    const FAKE_RESOURCE_IDENTIFIER = 2;
    const FAKE_SINGLE = 4;
    const FAKE_COLLECTION = 8;
    const FAKE_CAN_BE_NULL = 16;
    const FAKE_ERRORS = 32;

    abstract public function toArray(): ?array;

    abstract public function fake();

    public function addToObject(string $object, string $name, $value): void
    {
        if (!isset($this->{$object})) {
            $this->{$object} = [];
        }

        $this->{$object}[$name] = $value;
    }

    public function addToArray(string $object, $value): void
    {
        if (!isset($this->{$object})) {
            $this->{$object} = [];
        }

        $this->{$object}[] = $value;
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function toJson($options = 0): string
    {
        $json = json_encode($this->toArray(), $options);

        if ($json === false) {
            throw new \Exception(
                sprintf(Messages::JSON_ENCODE_ERROR, json_last_error_msg())
            );
        }

        return $json;
    }

    /**
     * This methods creates some members with fake names and values.
     *
     * The fake member is filled with the null value :
     * $options = [
     *      'member name' => null
     * ]
     *
     * The default array of methods is used to fill the fake value :
     * $options = [
     *      'member name' => []
     * ]
     *
     * Only the provided methods are used to fill the fake value :
     * $options = [
     *      'member name' => [ array of methods allowed to fake ]
     * ]
     *
     * If no key name is provided, a fake member name is generated :
     * $options = [
     *      null,
     *      [],
     *      [ array of methods allowed to fake ]
     * ]
     *
     * @param integer|array $options The number of keys to generate or an array of keys to use.
     *
     * @return array<string,mixed>
     */
    protected function fakeMembers($options): array
    {
        $faker = \Faker\Factory::create();

        if (is_int($options)) {
            $count = $options;
            $options = [];
            for ($i = 0; $i < $count; $i++) {
                $options[] = [];
            }
        }

        $values = [];
        foreach ($options as $key => $providers) {
            $name = $this->fakeMemberName($faker, $key);
            $value = $this->fakeValue($faker, $providers);

            $values[$name] = $value;
        }

        return $values;
    }

    /**
     * Returns a fake member's name.
     *
     * @param Generator $faker
     * @param string|integer|null $name
     *
     * @return string
     */
    protected function fakeMemberName(Generator $faker, $name = null): string
    {
        if (\is_null($name) || \is_int($name)) {
            $forbidden = ['id', 'type'];
            do {
                $name = $faker->unique()->word;
            } while (in_array($name, $forbidden));
        }

        if (\strpos($name, '/') === false) {
            return $name;
        }

        return $faker->unique()->regexify($name);
    }

    /**
     * Returns a fake member's value.
     *
     * @param Generator $faker
     * @param array<string>|null $providers
     * @return mixed
     */
    protected function fakeValue(Generator $faker, $providers = [])
    {
        $allowed = [
            'word',
            'sentence',
            'boolean',
            'randomNumber',
            'randomFloat',
            'date'
        ];

        if (is_null($providers)) {
            return null;
        }

        $method = $faker->randomElement(
            empty($providers) ? $allowed : $providers
        );

        return $faker->{$method};
    }
}
