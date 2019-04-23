<?php
declare (strict_types = 1);

namespace VGirol\JsonApiAssert;

/**
 * Generic class for exceptions
 *
 * @internal
 */
class Exception extends \RuntimeException
{
    const INVALID_ARGUMENT = 'Argument #%d%s of %s::%s() must be a %s';
}
