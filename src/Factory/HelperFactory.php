<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

class HelperFactory
{
    public static function getAliases(): array
    {
        return [
            'collection' => CollectionFactory::class,
            'jsonapi' => JsonapiFactory::class,
            'relationship' => RelationshipFactory::class,
            'resource-identifier' => ResourceIdentifierFactory::class,
            'resource-object' => ResourceObjectFactory::class
        ];
    }

    public static function getClassName(string $key): string
    {
        $aliases = static::getAliases();
        if (!isset($aliases[$key])) {
            throw new \Exception(
                sprintf('Inexistant key "%s".', $key)
            );
        }

        return $aliases[$key];
    }

    public static function create($alias, ...$args)
    {
        $className = static::getClassName($alias);

        return new $className(...$args);
    }
}
