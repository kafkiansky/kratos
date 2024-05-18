<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

/**
 * @template R of Response
 */
interface Request extends WriteBytes
{
    public static function apiKey(): ApiKey;

    /**
     * @return class-string<R>
     */
    public static function responseType(): string;
}
