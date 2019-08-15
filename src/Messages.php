<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker;

/**
 * All the messages
 */
abstract class Messages
{
    const JSON_ENCODE_ERROR =
    "An error occurs while encoding to JSON.\n%s";

    const FACTORY_INEXISTANT_KEY = 'Inexistant key "%s".';
}
