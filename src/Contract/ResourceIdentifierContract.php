<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for resource identifier factory.
 */
interface ResourceIdentifierContract extends
    FactoryContract,
    HasIdentificationContract,
    HasMetaContract
{
}
