<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for document object factory.
 */
interface DocumentContract extends
    FactoryContract,
    HasDataContract,
    HasErrorsContract,
    HasIncludedContract,
    HasJsonapiContract,
    HasLinksContract,
    HasMetaContract
{
}
