<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

/**
 * @template R of Response
 */
interface Request
{
    public function write(WriteBuffer $buffer, ApiVersion $version): void;

    public static function apiKey(): ApiKey;

    /**
     * @return class-string<R>
     */
    public static function responseType(): string;
}
