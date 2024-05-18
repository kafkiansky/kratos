<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos;

use Amp\Cancellation;
use Amp\Socket\ConnectContext;
use Amp\Socket\Socket;
use Psl\Type;

final readonly class ConnectionOptions
{
    /**
     * @param non-empty-list<non-empty-string>                                    $hosts
     * @param ?\Closure(non-empty-string, ?ConnectContext, ?Cancellation): Socket $connector
     */
    public function __construct(
        public array $hosts,
        public ?\Closure $connector = null,
    ) {
    }

    public static function fromString(string $hosts): self
    {
        return new self(
            Type\non_empty_vec(Type\non_empty_string())->assert(
                \array_map(
                    \trim(...),
                    \explode(',', $hosts),
                ),
            ),
        );
    }
}
