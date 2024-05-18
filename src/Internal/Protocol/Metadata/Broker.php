<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\Metadata;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Buffer;

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
    public static function fromBuffer(Buffer $buffer, ApiVersion $version): self
    {
        $nodeId = $buffer->consumeInt32();

        $host = match (true) {
            $version->less(ApiVersion::V9) => $buffer->consumeString(),
            default => $buffer->consumeCompactString(),
        };

        $port = $buffer->consumeInt32();

        $rack = match (true) {
            $version->gte(ApiVersion::V1) && $version->less(ApiVersion::V9) => $buffer->consumeString(),
            $version->gte(ApiVersion::V9) => $buffer->consumeCompactString(),
            default => null,
        };

        if ($version->gte(ApiVersion::V9)) {
            $buffer->readEmptyTaggedFieldArray();
        }

        return new self(
            $nodeId,
            $host,
            $port,
            $rack,
        );
    }
}
