<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert\Factory;

class HelperFactory
{
    protected function getAliases()
    {
        return [
            'collection' => CollectionFactory::class,
            'jsonapi' => JsonapiFactory::class,
            'relationship' => RelationshipFactory::class,
            'resource-identifier' => ResourceIdentifierFactory::class,
            'resource-object' => ResourceObjectFactory::class
        ];
    }

    public function getClassName(string $key)
    {
        $aliases = static::getAliases();
        if (!isset($aliases[$key])) {
            throw new \Exception(
                sprintf('Inexistant key "%s".', $key)
            );
        }

        return $aliases[$key];
    }
}
