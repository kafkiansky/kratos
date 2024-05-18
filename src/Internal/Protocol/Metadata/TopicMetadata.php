<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\Metadata;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Buffer;
use Kafkiansky\Kratos\Internal\Protocol\Error;

final readonly class TopicMetadata
{
    /**
     * @param PartitionMetadata[] $partitions
     */
    public function __construct(
        public Error $error,
        public string $name,
        public array $partitions = [],
        public bool $isInternal = false,
        public ?string $uuid = null,
        public ?int $topicAuthorizedOperations = null,
    ) {
    }

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public static function fromBuffer(Buffer $buffer, ApiVersion $version): self
    {
        $error = $buffer->readError();

        $name = match (true) {
            $version->less(ApiVersion::V9) => $buffer->consumeString(),
            default => $buffer->consumeCompactString(),
        };

        $uuid = match (true) {
            $version->gte(ApiVersion::V10) => $buffer->consumeBytes(16),
            default => null,
        };

        $isInternal = match (true) {
            $version->gte(ApiVersion::V1) => $buffer->consumeBool(),
            default => false,
        };

        $partitionsCount = match (true) {
            $version->less(ApiVersion::V9) => $buffer->readArrayLength(),
            default => $buffer->readCompactArrayLength(),
        };

        /** @var PartitionMetadata[] $partitions */
        $partitions = [];

        for ($i = 0; $i < $partitionsCount; ++$i) {
            $partitions[] = PartitionMetadata::fromBuffer($buffer, $version);
        }

        $topicAuthorizedOperations = match (true) {
            $version->gte(ApiVersion::V8) => $buffer->consumeInt32(),
            default => null,
        };

        if ($version->gte(ApiVersion::V9)) {
            $buffer->readEmptyTaggedFieldArray();
        }

        return new self(
            $error,
            $name,
            $partitions,
            $isInternal,
            $uuid,
            $topicAuthorizedOperations,
        );
    }
}
