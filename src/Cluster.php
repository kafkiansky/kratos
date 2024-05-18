<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos;

use Amp\ByteStream\StreamException;
use Amp\CancelledException;
use Kafkiansky\Binary\BinaryException;
use Kafkiansky\Kratos\Internal\Client\Connection;
use Amp\Socket;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Command;
use Kafkiansky\Kratos\Internal\Protocol\Metadata\MetadataResponse;

/**
 * @phpstan-import-type Connector from ConnectionOptions
 */
final class Cluster
{
    private ?Connection $broker = null;

    private ?Controller $controller = null;

    private function __construct(
        private readonly ConnectionOptions $connectionOptions,
    ) {}

    public static function fromConnectionOptions(ConnectionOptions $connectionOptions): self
    {
        return new self($connectionOptions);
    }

    /**
     * @throws BinaryException
     * @throws ConnectionException
     * @throws StreamException
     * @throws CancelledException
     */
    public function controller(): Controller
    {
        if (null !== $this->controller) {
            return $this->controller;
        }

        $this->broker ??= self::peekRandomConnection($this->connectionOptions);

        /** @var MetadataResponse $metadata */
        $metadata = $this->broker->request(Command::fetchMetadata(), ApiVersion::V1)->await();

        foreach ($metadata->brokers as $broker) {
            if ($metadata->controllerId === $broker->nodeId) {
                return $this->controller = new Controller(
                    self::connect(
                        (string) $broker,
                        $this->connectionOptions->connectionTimeout,
                        $this->connectionOptions->connector,
                    ),
                );
            }
        }

        throw new ConnectionException('No available controller was found.');
    }

    /**
     * @throws BinaryException
     * @throws ConnectionException
     */
    private static function peekRandomConnection(ConnectionOptions $connectionOptions): Connection
    {
        $exceptions = [];

        foreach ($connectionOptions as $host) {
            try {
                return self::connect($host, $connectionOptions->connectionTimeout, $connectionOptions->connector);
            } catch (Socket\ConnectException | CancelledException $e) {
                $exceptions[(string) $host] = $e->getMessage();
            }
        }

        throw new ConnectionException(
            vsprintf('%d of %d brokers are down: %s', [
                \count($connectionOptions),
                \count($connectionOptions),
                \implode('; ', \array_map(fn (string $host, string $exception): string => "$host: $exception", \array_keys($exceptions), \array_values($exceptions))),
            ])
        );
    }

    /**
     * @param non-empty-string $host
     * @param positive-int     $timeout
     * @param ?Connector       $connect
     *
     * @throws BinaryException
     * @throws Socket\ConnectException
     * @throws CancelledException
     */
    private static function connect(string $host, int $timeout, ?\Closure $connect = null): Connection
    {
        $connect ??= Socket\connect(...);

        return new Connection(
            $connect(
                $host,
                (new Socket\ConnectContext())
                    ->withConnectTimeout($timeout),
            ),
        );
    }
}
