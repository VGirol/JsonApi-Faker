<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

class HelperFactory
{
    const ERROR_INEXISTANT_KEY = 'Inexistant key "%s".';

    protected static function getAliases(): array
    {
        return [];
    }

    private static function getDefaultAliases(): array
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
        $aliases = array_merge(static::getDefaultAliases(), static::getAliases());
        if (!isset($aliases[$key])) {
            throw new \Exception(
                sprintf(static::ERROR_INEXISTANT_KEY, $key)
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
