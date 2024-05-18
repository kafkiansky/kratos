<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

enum ApiVersion: int
{
    case V0 = 0;
    case V1 = 1;
    case V2 = 2;
    case V3 = 3;
    case V5 = 5;
    case V6 = 6;
    case V7 = 7;
    case V8 = 8;
    case V9 = 9;
    case V10 = 10;
    case V11 = 11;
    case V12 = 12;
    case V13 = 13;
    case V14 = 14;
    case V15 = 15;
    case V16 = 16;

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
