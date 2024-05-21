<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\CreateTopics;

use Kafkiansky\Kratos\Internal\Protocol\ApiKey;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Request;
use Kafkiansky\Kratos\Internal\Protocol\WriteBuffer;

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

    public function write(WriteBuffer $buffer, ApiVersion $version): void
    {
        $buffer
            ->writeMap($this->topics, function (WriteBuffer $buffer, string $name, TopicDetail $detail): void {
                $buffer
                    ->writeString($name)
                    ->writeInt32($detail->numPartitions)
                    ->writeInt16($detail->replicationFactor)
                    ->writeMap($detail->assignments, static function (WriteBuffer $buffer, int $partition, array $assignments): void {
                        $buffer
                            ->writeInt32($partition)
                            ->writeArray($assignments, static function (WriteBuffer $buffer, int $assignment): void {
                                $buffer->writeInt32($assignment);
                            })
                        ;
                    })
                    ->writeMap($detail->configs, static function (WriteBuffer $buffer, string $configKey, ?string $configValue): void {
                        $buffer
                            ->writeString($configKey)
                            ->writeNullableString($configValue)
                        ;
                    })
                ;
            })
            ->writeInt32($this->timeout)
        ;

        if ($version->gte(new ApiVersion(1))) {
            $buffer->writeBool($this->validateOnly);
        }
    }
}
