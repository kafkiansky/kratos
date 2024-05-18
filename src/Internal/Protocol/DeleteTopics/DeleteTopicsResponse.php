<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\DeleteTopics;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Buffer;
use Kafkiansky\Kratos\Internal\Protocol\Error;
use Kafkiansky\Kratos\Internal\Protocol\Response;

/**
 * @see https://kafka.apache.org/protocol.html#The_Messages_DeleteTopics
 */
final readonly class DeleteTopicsResponse implements Response
{
    /**
     * @param array<non-empty-string, Error> $topicErrors
     */
    public function __construct(
        public ?int $throttleTime = null,
        public array $topicErrors = [],
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public static function read(Buffer $buffer, ApiVersion $version): self
    {
        return new self(
            match (true) {
                $version->gte(ApiVersion::V1) => $buffer->consumeInt32(),
                default => null,
            },
            \iterator_to_array(
                $buffer->consumeArrayIterator(function (Buffer $buffer): \Generator {
                    yield $buffer->consumeString() => $buffer->readError();
                }),
            ),
        );
    }
}
