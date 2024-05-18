<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\CreateTopics;

final readonly class TopicDetail
{
    /**
     * @param int<-1, max>           $numPartitions
     * @param int<-1, max>           $replicationFactor
     * @param array<int, int[]>      $assignments
     * @param array<string, ?string> $configs
     */
    public function __construct(
        public int $numPartitions,
        public int $replicationFactor,
        public array $assignments = [],
        public array $configs = [],
    ) {
    }
}
