<?php
namespace VGirol\JsonApiAssert;

/**
 * All the member's names
 */
abstract class Members
{
    const DATA = 'data';
    const ERRORS = 'errors';
    const META = 'meta';
    const JSONAPI = 'jsonapi';
    const LINKS = 'links';
    const INCLUDED = 'included';
}
