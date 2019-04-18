<?php
namespace VGirol\JsonApiAssert;

use VGirol\JsonApiAssert\Asserts\AssertArrays;
use VGirol\JsonApiAssert\Asserts\AssertAttributesObject;
use VGirol\JsonApiAssert\Asserts\AssertErrorsObject;
use VGirol\JsonApiAssert\Asserts\AssertJsonapiObject;
use VGirol\JsonApiAssert\Asserts\AssertLinksObject;
use VGirol\JsonApiAssert\Asserts\AssertMemberName;
use VGirol\JsonApiAssert\Asserts\AssertMembers;
use VGirol\JsonApiAssert\Asserts\AssertMetaObject;
use VGirol\JsonApiAssert\Asserts\AssertRelationshipsObject;
use VGirol\JsonApiAssert\Asserts\AssertResourceLinkage;
use VGirol\JsonApiAssert\Asserts\AssertResourceObject;
use VGirol\JsonApiAssert\Asserts\AssertStructure;

/**
 * This class provide a set of assertions to test documents using the JSON:API specification.
 */
class Assert
{
    use AssertArrays;
    use AssertAttributesObject;
    use AssertErrorsObject;
    use AssertJsonapiObject;
    use AssertLinksObject;
    use AssertMemberName;
    use AssertMembers;
    use AssertMetaObject;
    use AssertRelationshipsObject;
    use AssertResourceLinkage;
    use AssertResourceObject;
    use AssertStructure;
}
