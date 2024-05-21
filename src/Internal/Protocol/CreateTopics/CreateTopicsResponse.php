<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\CreateTopics;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\ReadBuffer;
use Kafkiansky\Kratos\Internal\Protocol\Response;

/**
 * @see https://kafka.apache.org/protocol.html#The_Messages_CreateTopics
 */
final readonly class CreateTopicsResponse implements Response
{
    /**
     * @param array<string, TopicError> $topicErrors
     */
    public function __construct(
        public ?int $throttleTime = null,
        public array $topicErrors = [],
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public static function read(ReadBuffer $buffer, ApiVersion $version): self
    {
        return new self(
            match (true) {
                $version->gte(new ApiVersion(2)) => $buffer->consumeInt32(),
                default => null,
            },
            \iterator_to_array(
                $buffer->consumeGenerator(static function (ReadBuffer $buffer): \Generator {
                    yield $buffer->consumeString() => new TopicError(
                        $buffer->consumeError(),
                        $buffer->consumeString(),
                    );
                }),
            ),
        );
    }
}
