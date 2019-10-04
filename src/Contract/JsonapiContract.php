<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for jsonapi object factory.
 */
interface JsonapiContract extends
    FactoryContract,
    HasMetaContract,
    HasVersionContract
{

}
