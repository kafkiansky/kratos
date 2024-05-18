<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\Metadata;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Buffer;
use Kafkiansky\Kratos\Internal\Protocol\Error;

final readonly class PartitionMetadata
{
    /**
     * @param int[] $replicas
     * @param int[] $isr
     * @param int[] $offlineReplicas
     */
    public function __construct(
        public Error $error,
        public int $id,
        public int $leader,
        public int $leaderEpoch,
        public array $replicas = [],
        public array $isr = [],
        public array $offlineReplicas = [],
    ) {
    }

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public static function fromBuffer(Buffer $buffer, ApiVersion $version): self
    {
        $error = $buffer->readError();

        $id = $buffer->consumeInt32();

        $leaderId = $buffer->consumeInt32();

        $leaderEpoch = match (true) {
            $version->gte(ApiVersion::V7) => $buffer->consumeInt32(),
            default => 0,
        };

        $replicas = \iterator_to_array(
            match (true) {
                $version->less(ApiVersion::V9) => $buffer->consumeArrayIterator(
                    fn (Buffer $buffer): int => $buffer->consumeInt32(),
                ),
                default => $buffer->consumeCompactArrayIterator(
                    fn (Buffer $buffer): int => $buffer->consumeInt32(),
                ),
            },
        );

        $isr = \iterator_to_array(
            match (true) {
                $version->less(ApiVersion::V9) => $buffer->consumeArrayIterator(
                    fn (Buffer $buffer): int => $buffer->consumeInt32(),
                ),
                default => $buffer->consumeCompactArrayIterator(
                    fn (Buffer $buffer): int => $buffer->consumeInt32(),
                ),
            },
        );

        $offlineReplicas = match (true) {
            $version->gte(ApiVersion::V5) => \iterator_to_array(
                match (true) {
                    $version->less(ApiVersion::V9) => $buffer->consumeArrayIterator(
                        fn (Buffer $buffer): int => $buffer->consumeInt32(),
                    ),
                    default => $buffer->consumeCompactArrayIterator(
                        fn (Buffer $buffer): int => $buffer->consumeInt32(),
                    ),
                },
            ),
            default => [],
        };

        if ($version->gte(ApiVersion::V9)) {
            $buffer->readEmptyTaggedFieldArray();
        }

        return new self(
            $error,
            $id,
            $leaderId,
            $leaderEpoch,
            $replicas,
            $isr,
            $offlineReplicas,
        );
    }
}
