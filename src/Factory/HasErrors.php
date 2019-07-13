<?php

declare(strict_types=1);

namespace VGirol\JsonApiAssert\Factory;

trait HasErrors
{
    /**
     * Undocumented variable
     *
     * @var array
     */
    public $errors;

    /**
     * Undocumented function
     *
     * @param array $errors
     * @return static
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param array $error
     * @return static
     */
    public function addError($error)
    {
        $this->addToArray('errors', $error);

        return $this;
    }
}
