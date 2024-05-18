<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

use Kafkiansky\Binary\BinaryException;

interface ReadBytes
{
    /**
     * @throws BinaryException
     */
    public static function read(Buffer $buffer, ApiVersion $version): self;
}
