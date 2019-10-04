<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Factory;

use VGirol\JsonApiFaker\Contract\ErrorContract;
use VGirol\JsonApiFaker\Exception\JsonApiFakerException;
use VGirol\JsonApiFaker\Messages;

/**
 * Add "errors" member
 */
trait HasErrors
{
    /**
     * The "errors" member
     *
     * @var array An array of objects implementing ErrorContract
     */
    protected $errors;

    /**
     * Set the "errors" member
     *
     * @param array $errors An array of objects implementing ErrorContract
     *
     * @return static
     * @throws JsonApiFakerException
     */
    public function setErrors(array $errors)
    {
        foreach ($errors as $error) {
            if (is_a($error, ErrorContract::class) === false) {
                throw new JsonApiFakerException(Messages::SET_ERRORS_BAD_TYPE);
            }
        }

        $this->errors = $errors;

        return $this;
    }

    /**
     * Get the "errors" member
     *
     * An array of ErrorContract objects
     *
     * @return array|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Add a single error to the "errors" member
     *
     * @param ErrorContract $error
     *
     * @return static
     */
    public function addError(ErrorContract $error)
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
     * @throws JsonApiFakerException
     */
    public function fakeErrors(int $count = 2)
    {
        $collection = [];
        for ($i = 0; $i < $count; $i++) {
            $collection[] = $this->generator
                ->error()
                ->fake();
        }

        return $this->setErrors($collection);
    }
}
