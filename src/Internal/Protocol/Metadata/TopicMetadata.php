<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\Metadata;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Error;
use Kafkiansky\Kratos\Internal\Protocol\ReadBuffer;

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
    public static function fromBuffer(ReadBuffer $buffer, ApiVersion $version): self
    {
        $error = $buffer->consumeError();

        $name = match (true) {
            $version->less(new ApiVersion(9)) => $buffer->consumeString(),
            default => $buffer->consumeCompactString(),
        };

        $uuid = match (true) {
            $version->gte(new ApiVersion(10)) => $buffer->consumeBytes(16),
            default => null,
        };

        $isInternal = match (true) {
            $version->gte(new ApiVersion(1)) => $buffer->consumeBool(),
            default => false,
        };

        $partitionsCount = match (true) {
            $version->less(new ApiVersion(9)) => $buffer->consumeArrayLength(),
            default => $buffer->consumeCompactArrayLength(),
        };

        /** @var PartitionMetadata[] $partitions */
        $partitions = [];

        for ($i = 0; $i < $partitionsCount; ++$i) {
            $partitions[] = PartitionMetadata::fromBuffer($buffer, $version);
        }

        $topicAuthorizedOperations = match (true) {
            $version->gte(new ApiVersion(8)) => $buffer->consumeInt32(),
            default => null,
        };

        if ($version->gte(new ApiVersion(9))) {
            $buffer->consumeEmptyTaggedFieldArray();
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
