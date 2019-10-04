<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker;

use VGirol\JsonApiFaker\Contract\CollectionContract;
use VGirol\JsonApiFaker\Contract\DocumentContract;
use VGirol\JsonApiFaker\Contract\ErrorContract;
use VGirol\JsonApiFaker\Contract\GeneratorContract;
use VGirol\JsonApiFaker\Contract\JsonapiContract;
use VGirol\JsonApiFaker\Contract\RelationshipContract;
use VGirol\JsonApiFaker\Contract\ResourceIdentifierContract;
use VGirol\JsonApiFaker\Contract\ResourceObjectContract;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;
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
     * @var array
     */
    private $factories;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->setDefaultFactories();
    }

    public function setFactory(string $key, ?string $class)
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
     * @return mixed
     * @throws JsonApiFakerException
     */
    public function create(string $alias, ...$args)
    {
        $className = $this->getClassName($alias);
        $factory = new $className(...$args);
        $factory->setGenerator($this);

        return $factory;
    }

    /**
     * @return CollectionContract
     * @throws JsonApiFakerException
     */
    public function collection(...$args)
    {
        return $this->create('collection', ...$args);
    }

    /**
     * @return DocumentContract
     * @throws JsonApiFakerException
     */
    public function document(...$args)
    {
        return $this->create('document', ...$args);
    }

    /**
     * @return ErrorContract
     * @throws JsonApiFakerException
     */
    public function error(...$args)
    {
        return $this->create('error', ...$args);
    }

    /**
     * @return JsonapiContract
     * @throws JsonApiFakerException
     */
    public function jsonapiObject(...$args)
    {
        return $this->create('jsonapi', ...$args);
    }

    /**
     * @return RelationshipContract
     * @throws JsonApiFakerException
     */
    public function relationship(...$args)
    {
        return $this->create('relationship', ...$args);
    }

    /**
     * @return ResourceIdentifierContract
     * @throws JsonApiFakerException
     */
    public function resourceIdentifier(...$args)
    {
        return $this->create('resource-identifier', ...$args);
    }

    /**
     * @return ResourceObjectContract
     * @throws JsonApiFakerException
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
     * @throws JsonApiFakerException
     */
    private function getClassName(string $key): string
    {
        if (!array_key_exists($key, $this->factories)) {
            throw new JsonApiFakerException(
                sprintf(Messages::FACTORY_INEXISTANT_KEY, $key)
            );
        }

        if ($this->factories[$key] === null) {
            throw new JsonApiFakerException(
                sprintf(Messages::FACTORY_FORBIDDEN_KEY, $key)
            );
        }

        return $this->factories[$key];
    }
}
