<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\CreateTopics;

use Kafkiansky\Kratos\Internal\Protocol\ApiKey;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Buffer;
use Kafkiansky\Kratos\Internal\Protocol\Request;

/**
 * @see https://kafka.apache.org/protocol.html#The_Messages_CreateTopics
 *
 * @template-implements Request<CreateTopicsResponse>
 */
final readonly class CreateTopicsRequest implements Request
{
    /**
     * @param non-empty-array<non-empty-string, TopicDetail> $topics
     * @param positive-int                                   $timeout
     */
    public function __construct(
        private array $topics,
        private int $timeout,
        private bool $validateOnly = false,
    ) {
    }

    public static function apiKey(): ApiKey
    {
        return ApiKey::CREATE_TOPICS;
    }

    /**
     * {@inheritdoc}
     */
    public static function responseType(): string
    {
        return CreateTopicsResponse::class;
    }

    public function write(Buffer $buffer, ApiVersion $version): void
    {
        $buffer
            ->writeMap($this->topics, function (Buffer $buffer, string $name, TopicDetail $detail): void {
                $buffer
                    ->writeString($name)
                    ->writeInt32($detail->numPartitions)
                    ->writeInt16($detail->replicationFactor)
                    ->writeMap($detail->assignments, static function (Buffer $buffer, int $partition, array $assignments): void {
                        $buffer
                            ->writeInt32($partition)
                            ->writeArray($assignments, static function (Buffer $buffer, int $assignment): void {
                                $buffer->writeInt32($assignment);
                            })
                        ;
                    })
                    ->writeMap($detail->configs, static function (Buffer $buffer, string $configKey, ?string $configValue): void {
                        $buffer
                            ->writeString($configKey)
                            ->writeNullableString($configValue)
                        ;
                    })
                ;
            })
            ->writeInt32($this->timeout)
        ;

        if ($version->gte(ApiVersion::V1)) {
            $buffer->writeBool($this->validateOnly);
        }
    }
}
