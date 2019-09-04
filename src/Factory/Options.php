<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

/**
 * This class provides constant values.
 */
abstract class Options
{
    const FAKE_RESOURCE_OBJECT = 1;
    const FAKE_RESOURCE_IDENTIFIER = 2;
    const FAKE_SINGLE = 4;
    const FAKE_COLLECTION = 8;
    const FAKE_CAN_BE_NULL = 16;
    const FAKE_ERRORS = 32;
}
