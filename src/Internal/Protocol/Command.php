<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

use Kafkiansky\Kratos\Internal\Protocol;

final readonly class Command
{
    public static function apiVersions(
        ?string $clientSoftwareName = null,
        ?string $clientSoftwareVersion = null,
    ): Protocol\ApiVersions\ApiVersionsRequest {
        return new Protocol\ApiVersions\ApiVersionsRequest(
            $clientSoftwareName,
            $clientSoftwareVersion,
        );
    }

    /**
     * @param non-empty-string[] $topics
     */
    public static function fetchMetadata(
        array $topics = [],
        bool $allowTopicAutoCreation = false,
    ): Protocol\Metadata\MetadataRequest {
        return new Protocol\Metadata\MetadataRequest(
            $topics,
            $allowTopicAutoCreation,
        );
    }

    /**
     * @param non-empty-array<non-empty-string, Protocol\CreateTopics\TopicDetail> $topics
     * @param positive-int                                                         $timeout
     */
    public static function createTopics(
        array $topics,
        int $timeout = 1000,
        bool $validateOnly = false,
    ): Protocol\CreateTopics\CreateTopicsRequest {
        return new Protocol\CreateTopics\CreateTopicsRequest(
            $topics,
            $timeout,
            $validateOnly,
        );
    }

    /**
     * @param non-empty-list<non-empty-string> $topics
     * @param positive-int                     $timeout
     */
    public static function deleteTopics(
        array $topics,
        int $timeout = 1000,
    ): Protocol\DeleteTopics\DeleteTopicsRequest {
        return new Protocol\DeleteTopics\DeleteTopicsRequest(
            $topics,
            $timeout,
        );
    }
}
