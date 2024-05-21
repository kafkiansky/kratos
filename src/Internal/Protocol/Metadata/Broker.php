<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\Metadata;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Buffer;
use Kafkiansky\Kratos\Internal\Protocol\ReadBuffer;

final readonly class Broker
{
    public function __construct(
        public int $nodeId,
        public string $host,
        public int $port,
        public ?string $rack = null,
    ) {
    }

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public static function fromBuffer(ReadBuffer $buffer, ApiVersion $version): self
    {
        $nodeId = $buffer->consumeInt32();

        $host = match (true) {
            $version->less(new ApiVersion(9)) => $buffer->consumeString(),
            default => $buffer->consumeCompactString(),
        };

        $port = $buffer->consumeInt32();

        $rack = match (true) {
            $version->gte(new ApiVersion(1)) && $version->less(new ApiVersion(9)) => $buffer->consumeString(),
            $version->gte(new ApiVersion(9)) => $buffer->consumeCompactString(),
            default => null,
        };

        if ($version->gte(new ApiVersion(9))) {
            $buffer->consumeEmptyTaggedFieldArray();
        }

        return new self(
            $nodeId,
            $host,
            $port,
            $rack,
        );
    }

    /**
     * @return non-empty-string
     */
    public function uri(): string
    {
        return "tcp://$this->host:$this->port";
    }
}
