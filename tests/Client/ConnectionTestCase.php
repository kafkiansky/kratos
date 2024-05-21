<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Tests\Client;

use Amp\Socket\Socket;
use Kafkiansky\Kratos\Internal\Client\Connection;
use PHPUnit\Framework\TestCase;
use Kafkiansky\Kratos\Internal\Protocol;

abstract class ConnectionTestCase extends TestCase
{
    /**
     * @param non-empty-string ...$buffers
     */
    final protected function roundTrip(string ...$buffers): Connection
    {
        $socket = $this->createMock(Socket::class);
        $socket
            ->expects(self::exactly(\count($buffers)))
            ->method('write')
        ;

        $socket
            ->method('read')
            ->willReturnOnConsecutiveCalls(
                ...\array_merge(
                    \array_map(self::hex2bin(...), $buffers),
                    [null],
                ),
            )
        ;

        return new Connection($socket);
    }

    /**
     * @param non-empty-string $path
     *
     * @return non-empty-string
     */
    private static function hex2bin(string $path): string
    {
        return Protocol\parseBytes(
            __DIR__.'/../resources/bin'.$path,
        );
    }
}
