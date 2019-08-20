<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Members;
use VGirol\JsonApiFaker\Messages;

/**
 * A factory for error object
 */
class ErrorFactory extends BaseFactory
{
    use HasIdentifier;
    use HasLinks;
    use HasMeta;

    /**
     * The "status" member
     *
     * @var string
     */
    public $status;

    /**
     * The "code" member
     *
     * @var string
     */
    public $code;

    /**
     * The "title" member
     *
     * @var string
     */
    public $title;

    /**
     * The "details" member
     *
     * @var string
     */
    public $details;

    /**
     * The "source" member
     *
     * @var array<string,mixed>
     */
    public $source;

    /**
     * Set one of the following member : status, code, title, details
     *
     * @param string $key
     * @param string $value
     *
     * @return static
     * @throws \Exception
     */
    public function set(string $key, string $value)
    {
        if (!property_exists($this, $key)) {
            throw new \Exception(sprintf(Messages::ERROR_OBJECT_INEXISTANT_KEY, $key));
        }

        $this->{$key} = $value;

        return $this;
    }

    /**
     * Set the "source" member
     *
     * @param array<string,mixed> $source
     *
     * @return static
     */
    public function setSource(array $source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @inheritDoc
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        $resource = [];
        if (isset($this->id)) {
            $resource[Members::ID] = $this->id;
        }
        if (isset($this->links)) {
            $resource[Members::LINKS] = $this->links;
        }
        if (isset($this->status)) {
            $resource[Members::STATUS] = $this->status;
        }
        if (isset($this->code)) {
            $resource[Members::CODE] = $this->code;
        }
        if (isset($this->title)) {
            $resource[Members::TITLE] = $this->title;
        }
        if (isset($this->details)) {
            $resource[Members::DETAILS] = $this->details;
        }
        if (isset($this->source)) {
            $resource[Members::SOURCE] = $this->source;
        }
        if (isset($this->meta)) {
            $resource[Members::META] = $this->meta;
        }

        return $resource;
    }

    /**
     * Fill the error object with fake values
     * ("id", "links", "meta", "status", "code", "title", "details" and "source").
     *
     * @return static
     */
    public function fake()
    {
        return $this->fakeIdentifier()
            ->fakeLinks(['about' => ['url']])
            ->fakeMeta()
            ->fakeStatus()
            ->fakeCode()
            ->fakeTitle()
            ->fakeDetails()
            ->fakeSource();
    }

    /**
     * Fill the "status" member with fake value
     *
     * @return static
     */
    private function fakeStatus()
    {
        $status = [
            '200', '201', '202', '203', '204', '205', '206', '207', '208', '226',
            '300', '301', '302', '303', '304', '305', '307', '308',
            '400', '401', '402', '403', '404', '405', '406', '407', '408', '409',
            '410', '411', '412', '413', '414', '415', '416', '417', '422', '423', '424', '426', '428', '429', '431',
            '500', '501', '502', '503', '504', '505', '506', '507', '508', '510', '511'
        ];
        $faker = \Faker\Factory::create();

        return $this->set('status', strval($faker->randomElement($status)));
    }

    /**
     * Fill the "code" member with fake value
     *
     * @return static
     */
    private function fakeCode()
    {
        $faker = \Faker\Factory::create();

        return $this->set('code', strval($faker->numberBetween(1, 100)));
    }

    /**
     * Fill the "title" member with fake value
     *
     * @return static
     */
    private function fakeTitle()
    {
        $faker = \Faker\Factory::create();

        return $this->set('title', $faker->sentence);
    }

    /**
     * Fill the "details" member with fake value
     *
     * @return static
     */
    private function fakeDetails()
    {
        $faker = \Faker\Factory::create();

        return $this->set('details', $faker->paragraph);
    }

    /**
     * Fill the "source" member with fake value
     *
     * @return static
     */
    private function fakeSource()
    {
        $faker = \Faker\Factory::create();

        return $this->setSource(
            [
                'parameter' => $faker->word
            ]
        );
    }
}
