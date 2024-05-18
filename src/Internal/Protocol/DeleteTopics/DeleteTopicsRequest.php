<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\DeleteTopics;

use Kafkiansky\Kratos\Internal\Protocol\ApiKey;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Buffer;
use Kafkiansky\Kratos\Internal\Protocol\Request;

/**
 * @see https://kafka.apache.org/protocol.html#The_Messages_DeleteTopics
 *
 * @template-implements Request<DeleteTopicsResponse>
 */
final readonly class DeleteTopicsRequest implements Request
{
    /**
     * @param non-empty-list<non-empty-string> $topics
     * @param positive-int                     $timeout
     */
    public function __construct(
        private array $topics,
        private int $timeout,
    ) {
    }

    public static function apiKey(): ApiKey
    {
        return ApiKey::DELETE_TOPICS;
    }

    /**
     * {@inheritdoc}
     */
    public static function responseType(): string
    {
        return DeleteTopicsResponse::class;
    }

    public function write(Buffer $buffer, ApiVersion $version): void
    {
        $buffer
            ->writeArray($this->topics, static function (Buffer $buffer, string $topic): void {
                $buffer->writeString($topic);
            })
            ->writeInt32($this->timeout)
        ;
    }
}
