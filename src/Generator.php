<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker;

use VGirol\JsonApiFaker\Factory\CollectionFactory;
use VGirol\JsonApiFaker\Factory\JsonapiFactory;
use VGirol\JsonApiFaker\Factory\RelationshipFactory;
use VGirol\JsonApiFaker\Factory\ResourceIdentifierFactory;
use VGirol\JsonApiFaker\Factory\ResourceObjectFactory;

class Generator
{
    private $factories;

    public function __construct()
    {
        $this->setDefaultFactories();
    }

    public function setFactory(string $key, string $class)
    {
        $this->factories[$key] = $class;

        return $this;
    }

    public function create($alias, ...$args)
    {
        $className = $this->getClassName($alias);

        return new $className(...$args);
    }

    public function collection(...$args)
    {
        return $this->create('collection', ...$args);
    }

    public function jsonapiObject(...$args)
    {
        return $this->create('jsonapi', ...$args);
    }

    public function relationship(...$args)
    {
        return $this->create('relationship', ...$args);
    }

    public function resourceIdentifier(...$args)
    {
        return $this->create('resource-identifier', ...$args);
    }

    public function resourceObject(...$args)
    {
        return $this->create('resource-object', ...$args);
    }

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
