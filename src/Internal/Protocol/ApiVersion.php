<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

/**
 * @phpstan-type Version = int<0, 32767>
 */
final readonly class ApiVersion
{
    /**
     * @param Version $value
     */
    public function __construct(
        public int $value,
    ) {
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function less(self $other): bool
    {
        return $this->value < $other->value;
    }

    public function greater(self $other): bool
    {
        return $this->value > $other->value;
    }

    public function gte(self $other): bool
    {
        return $this->value >= $other->value;
    }
}
