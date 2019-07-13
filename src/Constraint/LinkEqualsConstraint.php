<?php

declare(strict_types=1);

namespace VGirol\JsonApiAssert\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * A constraint class to assert that a link object equals an expected value.
 */
class LinkEqualsConstraint extends Constraint
{
    /**
     * @var string|null
     */
    private $expected;

    /**
     * Class constructor.
     *
     * @param string|null $expected
     */
    public function __construct($expected)
    {
        $this->expected = $expected;
    }

    /**
     * Returns a string representation of the constraint.
     */
    public function toString(): string
    {
        return \sprintf(
            'equals "%s"',
            $this->expected
        );
    }

    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param mixed $other value or object to evaluate
     */
    protected function matches($other): bool
    {
        if (is_null($this->expected)) {
            return \is_null($other);
        }

        if (is_null($other)) {
            return false;
        }

        $linkElms = explode('?', $other);
        $expectedElms = explode('?', $this->expected);

        if (count($expectedElms) != count($linkElms)) {
            return false;
        }

        if ($expectedElms[0] != $linkElms[0]) {
            return false;
        }

        if (count($linkElms) == 1) {
            return true;
        }

        $expectedQuery = explode('&', $expectedElms[1]);
        $linkQuery = explode('&', $linkElms[1]);

        if (count($expectedQuery) != count($linkQuery)) {
            return false;
        }

        $diff = array_diff($expectedQuery, $linkQuery);

        return count($diff) === 0;
    }
}
