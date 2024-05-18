<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Client;

use Amp\DeferredFuture;
use Amp\Future;
use Amp\Socket\Socket;
use Amp;
use Kafkiansky\Kratos\Internal\Protocol;

/**
 * @phpstan-type FutureCompletion = callable(Protocol\Buffer): void
 * @phpstan-import-type CorrelationId from CorrelationIdGenerator
 */
final class Connection
{
    /** @var array<CorrelationId, FutureCompletion> */
    private array $futures = [];

    private CorrelationIdGenerator $correlationIdGenerator;

    private FrameReader $inbound;

    private FrameWriter $outbound;

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function __construct(
        private readonly Socket $socket,
        ?string $clientId = null,
    ) {
        $this->inbound = new FrameReader();
        $this->outbound = new FrameWriter($clientId);
        $this->correlationIdGenerator = new CorrelationIdGenerator();

        Amp\async($this->ioLoop(...));
    }

    /**
     * @template T of Protocol\Response
     *
     * @param Protocol\Request<T> $request
     *
     * @throws \Kafkiansky\Binary\BinaryException
     * @throws \Amp\ByteStream\StreamException
     *
     * @return Future<T>
     */
    public function request(Protocol\Request $request, Protocol\ApiVersion $version): Future
    {
        $correlationId = $this->correlationIdGenerator->next();

        $this->outbound->append($request, $version, $correlationId);
        $this->outbound->write($this->socket);

        $responseType = $request::responseType();

        /* @var DeferredFuture<T> $deferred */
        $deferred = new DeferredFuture();

        $this->futures[$correlationId] = static function (Protocol\Buffer $buffer) use (
            &$deferred,
            $responseType,
            $version,
        ): void {
            try {
                $deferred->complete(
                    $responseType::read($buffer, $version),
                );
            } catch (\Throwable $e) {
                $deferred->error($e);
            }
        };

        return $deferred->getFuture();
    }

    public function close(): void
    {
        if (!$this->socket->isClosed()) {
            $this->socket->close();
        }
    }

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    private function ioLoop(): void
    {
        while (null !== ($frame = $this->socket->read())) {
            $this->inbound->write($frame);

            foreach ($this->inbound->responses() as $correlationId => $buffer) {
                if (isset($this->futures[$correlationId])) {
                    ($this->futures[$correlationId])($buffer);

                    unset($this->futures[$correlationId]);
                }
            }
        }
    }
}
