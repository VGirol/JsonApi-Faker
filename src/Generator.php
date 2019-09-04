<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker;

use VGirol\JsonApiFaker\Contract\GeneratorContract;
use VGirol\JsonApiFaker\Factory\CollectionFactory;
use VGirol\JsonApiFaker\Factory\DocumentFactory;
use VGirol\JsonApiFaker\Factory\ErrorFactory;
use VGirol\JsonApiFaker\Factory\JsonapiFactory;
use VGirol\JsonApiFaker\Factory\RelationshipFactory;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Factory\ResourceObjectFactory;

/**
 * This class is an helper to generate factories.
 */
class Generator implements GeneratorContract
{
    /**
     * All the available factories
     *
     * @var array<string,string|null>
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
     * @inheritDoc
     */
    public function setFactory(string $key, ?string $class)
    {
        $this->factories[$key] = $class;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function create(string $alias, ...$args)
    {
        $className = $this->getClassName($alias);
        $factory = new $className(...$args);
        $factory->setGenerator($this);

        return $factory;
    }

    /**
     * @inheritDoc
     */
    public function collection(...$args)
    {
        return $this->create('collection', ...$args);
    }

    /**
     * @inheritDoc
     */
    public function document(...$args)
    {
        return $this->create('document', ...$args);
    }

    /**
     * @inheritDoc
     */
    public function error(...$args)
    {
        return $this->create('error', ...$args);
    }

    /**
     * @inheritDoc
     */
    public function jsonapiObject(...$args)
    {
        return $this->create('jsonapi', ...$args);
    }

    /**
     * @inheritDoc
     */
    public function relationship(...$args)
    {
        return $this->create('relationship', ...$args);
    }

    /**
     * @inheritDoc
     */
    public function resourceIdentifier(...$args)
    {
        return $this->create('resource-identifier', ...$args);
    }

    /**
     * @inheritDoc
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
            'document' => DocumentFactory::class,
            'error' => ErrorFactory::class,
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
        if (!array_key_exists($key, $this->factories)) {
            throw new \Exception(
                sprintf(Messages::FACTORY_INEXISTANT_KEY, $key)
            );
        }

        if ($this->factories[$key] === null) {
            throw new \Exception(
                sprintf(Messages::FACTORY_FORBIDDEN_KEY, $key)
            );
        }

        return $this->factories[$key];
    }
}
