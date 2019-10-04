<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for resource object factory.
 */
interface ResourceObjectContract extends
    FactoryContract,
    HasAttributesContract,
    HasIdentificationContract,
    HasLinksContract,
    HasMetaContract,
    HasRelationshipsContract
{
 
}
