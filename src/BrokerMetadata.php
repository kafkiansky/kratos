<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos;

final readonly class BrokerMetadata
{
    public function __construct(
        public bool $isController,
    ) {
    }
}
