<?php
namespace VGirol\JsonApiAssert\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\ExpectationFailedException;

class ContainsOnlyAllowedMembersConstraint extends Constraint
{
    /**
     * @var array
     */
    private $members;

    public function __construct(array $members)
    {
        $this->members = $members;
    }

    /**
     * Returns a string representation of the constraint.
     */
    public function toString(): string
    {
        return \sprintf(
            'contains only elements of "%s"',
            \implode(', ', $this->members)
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
        if (!is_array($other)) {
            return false;
        }

        foreach (array_keys($other) as $key) {
            if (!in_array($key, $this->members)) {
                return false;
            }
        }

        return true;
    }
}
