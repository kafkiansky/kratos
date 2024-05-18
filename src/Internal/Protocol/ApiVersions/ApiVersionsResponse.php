<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\ApiVersions;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Buffer;
use Kafkiansky\Kratos\Internal\Protocol\Error;
use Kafkiansky\Kratos\Internal\Protocol\Response;

/**
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
    public static function read(Buffer $buffer, ApiVersion $version): self
    {
        $error = $buffer->readError();

        $keysCount = match (true) {
            $version->gte(ApiVersion::V3) => $buffer->readCompactArrayLength(),
            default => $buffer->readArrayLength(),
        };

        $keys = [];
        for ($i = 0; $i < $keysCount; ++$i) {
            $keys[] = ApiVersionRange::fromBuffer($buffer, $version);
        }

        $throttleTimeInMs = null;
        if ($version->gte(ApiVersion::V1)) {
            $throttleTimeInMs = $buffer->consumeInt32();
        }

        if ($version->gte(ApiVersion::V3)) {
            $buffer->readEmptyTaggedFieldArray();
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
