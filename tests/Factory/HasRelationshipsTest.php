<?php

namespace VGirol\JsonApiFaker\Tests\Factory;

use VGirol\JsonApiFaker\Factory\BaseFactory;
use VGirol\JsonApiFaker\Factory\HasRelationships;
use VGirol\JsonApiFaker\Testing\CheckMethods;
use VGirol\JsonApiFaker\Tests\TestCase;

class HasRelationshipsTest extends TestCase
{
    use CheckMethods;

    /**
     * @test
     */
    public function addRelationship()
    {
        $this->checkAddSingle(
            new class extends BaseFactory
            {
                use HasRelationships;

                public function toArray(): ?array
                {
                    return null;
                }

                public function fake()
                {
                    return $this;
                }
            },
            'addRelationship',
            'relationships',
            [
                'relation1' => 'value1'
            ],
            [
                'relation2' => 'value2'
            ]
        );
    }
}
