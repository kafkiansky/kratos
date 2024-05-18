<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Client;

use Kafkiansky\Kratos\Internal\Protocol;

/**
 * @phpstan-import-type CorrelationId from CorrelationIdGenerator
 */
final readonly class FrameReader
{
    private const int RESPONSE_SIZE_IN_BYTES = 4;

    private Protocol\Buffer $buffer;

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function __construct()
    {
        $this->buffer = Protocol\Buffer::zeroed();
    }

    public function write(string $bytes): void
    {
        $this->buffer->write($bytes);
    }

    /**
     * @return \Generator<CorrelationId, Protocol\Buffer>
     *
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function responses(): \Generator
    {
        while ($this->buffer->size() > 0) {
            if ($this->buffer->size() < self::RESPONSE_SIZE_IN_BYTES) {
                break;
            }

            if ($this->buffer->size() < $this->buffer->readInt32()) {
                break;
            }

            $size = $this->buffer->consumeInt32();

            /** @var CorrelationId $correlationId */
            $correlationId = $this->buffer->consumeUint32();

            yield $correlationId => $this->buffer->cut($size - self::RESPONSE_SIZE_IN_BYTES);
        }
    }
}
