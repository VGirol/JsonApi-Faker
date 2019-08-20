<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker;

use VGirol\JsonApiFaker\Factory\CollectionFactory;
use VGirol\JsonApiFaker\Factory\FactoryContract;
use VGirol\JsonApiFaker\Factory\JsonapiFactory;
use VGirol\JsonApiFaker\Factory\RelationshipFactory;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Factory\ResourceObjectFactory;

/**
 * This class is an helper to generate factories.
 */
class Generator
{
    /**
     * All the available factories
     *
     * @var array<string,string>
     */
    private $factories;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->setDefaultFactories();
    }

    /**
     * Set a factory
     *
     * @param string $key
     * @param string $class
     *
     * @return static
     */
    public function setFactory(string $key, string $class)
    {
        $this->factories[$key] = $class;

        return $this;
    }

    /**
     * Create a factory
     *
     * @param string $alias
     * @param mixed ...$args
     *
     * @return FactoryContract
     * @throws \Exception
     */
    public function create(string $alias, ...$args)
    {
        $className = $this->getClassName($alias);

        return new $className(...$args);
    }

    /**
     * Create a collection factory
     *
     * @param mixed ...$args
     *
     * @return FactoryContract
     * @throws \Exception
     */
    public function collection(...$args)
    {
        return $this->create('collection', ...$args);
    }

    /**
     * Create a jsonapi object factory
     *
     * @param mixed ...$args
     *
     * @return FactoryContract
     * @throws \Exception
     */
    public function jsonapiObject(...$args)
    {
        return $this->create('jsonapi', ...$args);
    }

    /**
     * Create a relationship object factory
     *
     * @param mixed ...$args
     *
     * @return FactoryContract
     * @throws \Exception
     */
    public function relationship(...$args)
    {
        return $this->create('relationship', ...$args);
    }

    /**
     * Create a resource identifier factory
     *
     * @param mixed ...$args
     *
     * @return FactoryContract
     * @throws \Exception
     */
    public function resourceIdentifier(...$args)
    {
        return $this->create('resource-identifier', ...$args);
    }

    /**
     * Create a resource object factory
     *
     * @param mixed ...$args
     *
     * @return FactoryContract
     * @throws \Exception
     */
    public function resourceObject(...$args)
    {
        return $this->create('resource-object', ...$args);
    }

    /**
     * Set the default factories.
     *
     * @return void
     */
    private function setDefaultFactories()
    {
        $this->factories = [
            'collection' => CollectionFactory::class,
            'jsonapi' => JsonapiFactory::class,
            'relationship' => RelationshipFactory::class,
            'resource-identifier' => ResourceIdentifierFactory::class,
            'resource-object' => ResourceObjectFactory::class
        ];
    }

    /**
     * Retrieve the factory class name
     *
     * @param string $key
     *
     * @return string
     * @throws \Exception
     */
    private function getClassName(string $key): string
    {
        if (!isset($this->factories[$key])) {
            throw new \Exception(
                sprintf(Messages::FACTORY_INEXISTANT_KEY, $key)
            );
        }

        return $this->factories[$key];
    }
}
