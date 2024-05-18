<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos;

use Kafkiansky\Kratos\Internal\Client\Connection;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Command;

final readonly class Controller
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    /**
     * @param non-empty-list<non-empty-string> $topics
     */
    public function deleteTopics(array $topics): void
    {
        $this->connection->request(Command::deleteTopics($topics), ApiVersion::V3)->await();
    }
}
