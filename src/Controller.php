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
     *
     * @throws \Amp\ByteStream\StreamException
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function deleteTopics(array $topics): void
    {
        $this->connection->request(Command::deleteTopics($topics), new ApiVersion(3))->await();
    }
}
