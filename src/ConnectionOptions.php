<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos;

use Amp\Cancellation;
use Amp\Socket\ConnectContext;
use Amp\Socket\Socket;
use Psl\Type;

/**
 * @phpstan-type Connector = \Closure(non-empty-string, ?ConnectContext, ?Cancellation): Socket
 *
 * @template-implements \IteratorAggregate<non-empty-string>
 */
final readonly class ConnectionOptions implements
    \IteratorAggregate,
    \Stringable,
    \JsonSerializable,
    \Countable
{
    /**
     * @param non-empty-list<non-empty-string> $hosts
     * @param positive-int                     $connectionTimeout
     * @param ?Connector                       $connector
     */
    public function __construct(
        public array $hosts,
        public int $connectionTimeout = 10,
        public ?\Closure $connector = null,
    ) {
    }

    /**
     * @param non-empty-string $hosts
     * @param positive-int     $connectionTimeout
     */
    public static function fromString(string $hosts, int $connectionTimeout = 10): self
    {
        return new self(
            Type\non_empty_vec(Type\non_empty_string())->assert(
                \array_map(
                    \trim(...),
                    \explode(',', $hosts),
                ),
            ),
            $connectionTimeout,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Traversable
    {
        yield from $this->hosts;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return \implode(',', $this->hosts);
    }

    /**
     * @return non-empty-list<non-empty-string>
     */
    public function jsonSerialize(): array
    {
        return $this->hosts;
    }

    /**
     * @return positive-int
     */
    public function count(): int
    {
        return \count($this->hosts);
    }
}
