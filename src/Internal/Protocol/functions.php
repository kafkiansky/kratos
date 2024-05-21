<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

use Psl\Type;

/**
 * @param non-empty-string $bytes
 * @param non-empty-string $path
 */
function dumpBytes(string $bytes, string $path): void
{
    file_put_contents(
        $path,
        \chunk_split(
            \chunk_split(
                \bin2hex($bytes),
                2,
                ' ',
            ),
            120,
            \PHP_EOL,
        ),
    );
}

/**
 * @param non-empty-string $path
 *
 * @return non-empty-string
 */
function parseBytes(string $path): string
{
    return Type\non_empty_string()->assert(
        \hex2bin(
            \str_replace(
                [' ', \PHP_EOL],
                '',
                Type\string()->assert(\file_get_contents($path)),
            ),
        ),
    );
}
