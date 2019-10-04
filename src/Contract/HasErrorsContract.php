<?php

declare(strict_types=1);

namespace VGirol\JsonApiFaker\Contract;

/**
 * Interface for classes having errors property.
 */
interface HasErrorsContract
{
    /**
     * Set the "errors" member
     *
     * @param array $errors An array of ErrorContract objects
     *
     * @return static
     */
    public function setErrors(array $errors);

    /**
     * Get the "errors" member
     *
     * An array of ErrorContract objects
     *
     * @return array|null
     */
    public function getErrors(): ?array;

    /**
     * Add a single error to the "errors" member
     *
     * @param ErrorContract $error
     *
     * @return static
     */
    public function addError(ErrorContract $error);

    /**
     * Fill the "errors" member with fake values
     *
     * @param integer $count
     *
     * @return static
     */
    public function fakeErrors(int $count = 2);
}
