<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for relationship object factory.
 */
interface RelationshipContract extends
    FactoryContract,
    HasDataContract,
    HasLinksContract,
    HasMetaContract
{
 
}
