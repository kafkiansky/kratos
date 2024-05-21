<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

use Kafkiansky\Binary\BinaryException;

interface Response
{
    /**
     * @throws BinaryException
     */
    public static function read(ReadBuffer $buffer, ApiVersion $version): self;
}
