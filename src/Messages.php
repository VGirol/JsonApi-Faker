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

    const FACTORY_FORBIDDEN_KEY = 'The key "%s" is forbidden.';

    const ERROR_OBJECT_INEXISTANT_KEY = 'Inexistant key "%s".';

    const ERROR_COLLECTION_NOT_SET = 'The collection is not set.';

    const SET_DATA_BAD_TYPE =
    'The data must be an instance of ResourceIdentifierContract, ResourceObjectContract or CollectionContract
     or null value.';

    const SET_ERRORS_BAD_TYPE =
     'Each item of the array must be an instance of ErrorContract.';
}
