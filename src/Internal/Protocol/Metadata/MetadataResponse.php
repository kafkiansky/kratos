<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\Metadata;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Buffer;
use Kafkiansky\Kratos\Internal\Protocol\Response;

final readonly class MetadataResponse implements Response
{
    /**
     * @param Broker[]        $brokers
     * @param TopicMetadata[] $topics
     */
    public function __construct(
        public array $brokers = [],
        public array $topics = [],
        public ?int $throttleTimeMs = null,
        public ?string $clusterId = null,
        public ?int $controllerId = null,
        public ?int $clusterAuthorizedOperations = null,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public static function read(Buffer $buffer, ApiVersion $version): self
    {
        $throttleTimeInMs = match (true) {
            $version->gte(ApiVersion::V3) => $buffer->consumeInt32(),
            default => null,
        };

        $brokersCount = match (true) {
            $version->less(ApiVersion::V9) => $buffer->readArrayLength(),
            default => $buffer->readCompactArrayLength(),
        };

        /** @var Broker[] $brokers */
        $brokers = [];

        for ($i = 0; $i < $brokersCount; ++$i) {
            $brokers[] = Broker::fromBuffer($buffer, $version);
        }

        $clusterId = match (true) {
            $version->gte(ApiVersion::V2) => match (true) {
                $version->less(ApiVersion::V9) => $buffer->consumeString(),
                default => $buffer->consumeCompactString(),
            },
            default => null,
        };

        $controllerId = match (true) {
            $version->gte(ApiVersion::V1) => $buffer->consumeInt32(),
            default => null,
        };

        $topicsCount = match (true) {
            $version->less(ApiVersion::V9) => $buffer->readArrayLength(),
            default => $buffer->readCompactArrayLength(),
        };

        /** @var TopicMetadata[] $topics */
        $topics = [];

        for ($i = 0; $i < $topicsCount; ++$i) {
            $topics[] = TopicMetadata::fromBuffer($buffer, $version);
        }

        $clusterAuthorizedOperations = match (true) {
            $version->gte(ApiVersion::V8) => $buffer->consumeInt32(),
            default => null,
        };

        if ($version->gte(ApiVersion::V9)) {
            $buffer->readEmptyTaggedFieldArray();
        }

        return new self(
            $brokers,
            $topics,
            $throttleTimeInMs,
            $clusterId,
            $controllerId,
            $clusterAuthorizedOperations,
        );
    }
}
