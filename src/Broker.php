<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos;

use Kafkiansky\Kratos\Internal\Client\Connection;

final readonly class Broker
{
    public function __construct(
        private Connection $connection,
    ) {
    }
}
