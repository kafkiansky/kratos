<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\Metadata;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Error;
use Kafkiansky\Kratos\Internal\Protocol\ReadBuffer;

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
    public static function fromBuffer(ReadBuffer $buffer, ApiVersion $version): self
    {
        $error = $buffer->consumeError();

        $id = $buffer->consumeInt32();

        $leaderId = $buffer->consumeInt32();

        $leaderEpoch = match (true) {
            $version->gte(new ApiVersion(7)) => $buffer->consumeInt32(),
            default => 0,
        };

        $replicas = \iterator_to_array(
            match (true) {
                $version->less(new ApiVersion(9)) => $buffer->consumeArrayIterator(
                    fn (ReadBuffer $buffer): int => $buffer->consumeInt32(),
                ),
                default => $buffer->consumeCompactArrayIterator(
                    fn (ReadBuffer $buffer): int => $buffer->consumeInt32(),
                ),
            },
        );

        $isr = \iterator_to_array(
            match (true) {
                $version->less(new ApiVersion(9)) => $buffer->consumeArrayIterator(
                    fn (ReadBuffer $buffer): int => $buffer->consumeInt32(),
                ),
                default => $buffer->consumeCompactArrayIterator(
                    fn (ReadBuffer $buffer): int => $buffer->consumeInt32(),
                ),
            },
        );

        $offlineReplicas = match (true) {
            $version->gte(new ApiVersion(5)) => \iterator_to_array(
                match (true) {
                    $version->less(new ApiVersion(9)) => $buffer->consumeArrayIterator(
                        fn (ReadBuffer $buffer): int => $buffer->consumeInt32(),
                    ),
                    default => $buffer->consumeCompactArrayIterator(
                        fn (ReadBuffer $buffer): int => $buffer->consumeInt32(),
                    ),
                },
            ),
            default => [],
        };

        if ($version->gte(new ApiVersion(9))) {
            $buffer->consumeEmptyTaggedFieldArray();
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
