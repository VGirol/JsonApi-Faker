<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

/**
 * Add "errors" member
 */
trait HasErrors
{
    /**
     * The "errors" member
     *
     * @var array<ErrorFactory>
     */
    public $errors;

    /**
     * Set the "errors" member
     *
     * @param array<ErrorFactory> $errors
     *
     * @return static
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Add a single error to the "errors" member
     *
     * @param ErrorFactory $error
     *
     * @return static
     */
    public function addError($error)
    {
        $this->addToArray('errors', $error);

        return $this;
    }

    /**
     * Fill the "errors" member with fake values
     *
     * @param integer $count
     *
     * @return static
     */
    public function fakeErrors($count = 2)
    {
        $collection = [];
        for ($i = 0; $i < $count; $i++) {
            $collection[] = (new ErrorFactory)->fake();
        }

        return $this->setErrors($collection);
    }
}
