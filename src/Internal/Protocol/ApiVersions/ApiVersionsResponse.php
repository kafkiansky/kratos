<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\ApiVersions;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\ReadBuffer;
use Kafkiansky\Kratos\Internal\Protocol\Error;
use Kafkiansky\Kratos\Internal\Protocol\Response;

/**
 * @see https://kafka.apache.org/protocol.html#The_Messages_ApiVersions
 *
 * @template-implements \IteratorAggregate<array-key, ApiVersionRange>
 */
final readonly class ApiVersionsResponse implements
    Response,
    \IteratorAggregate,
    \Countable
{
    /**
     * @param ApiVersionRange[] $ranges
     */
    public function __construct(
        public Error $error,
        public array $ranges = [],
        public ?int $throttleTimeInMs = null,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public static function read(ReadBuffer $buffer, ApiVersion $version): self
    {
        $error = $buffer->consumeError();

        $keysCount = match (true) {
            $version->gte(new ApiVersion(3)) => $buffer->consumeCompactArrayLength(),
            default => $buffer->consumeArrayLength(),
        };

        $keys = [];
        for ($i = 0; $i < $keysCount; ++$i) {
            $keys[] = ApiVersionRange::fromBuffer($buffer, $version);
        }

        $throttleTimeInMs = null;
        if ($version->gte(new ApiVersion(1))) {
            $throttleTimeInMs = $buffer->consumeInt32();
        }

        if ($version->gte(new ApiVersion(3))) {
            $buffer->consumeEmptyTaggedFieldArray();
        }

        return new self(
            $error,
            $keys,
            $throttleTimeInMs,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        yield from $this->ranges;
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return \count($this->ranges);
    }
}
