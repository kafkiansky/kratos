<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

interface WriteBytes
{
    public function write(Buffer $buffer, ApiVersion $version): void;
}
