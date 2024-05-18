<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Tests\Client;

use Kafkiansky\Kratos\Internal\Protocol\ApiKey;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersions\ApiVersionRange;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersions\ApiVersionsRequest;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersions\ApiVersionsResponse;
use Kafkiansky\Kratos\Internal\Protocol\Error;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(ApiVersionsRequest::class)]
#[CoversClass(ApiVersionsResponse::class)]
final class ApiVersionsTest extends ConnectionTestCase
{
    public static function fixtures(): iterable
    {
        yield 'v3' => [
            ApiVersion::V3,
            new ApiVersionsResponse(
                Error::NONE,
                [
                    new ApiVersionRange(
                        ApiKey::PRODUCE,
                        0,
                        10,
                    ),
                    new ApiVersionRange(
                        ApiKey::FETCH,
                        0,
                        16,
                    ),
                    new ApiVersionRange(
                        ApiKey::LIST_OFFSETS,
                        0,
                        8,
                    ),
                    new ApiVersionRange(
                        ApiKey::METADATA,
                        0,
                        12,
                    ),
                    new ApiVersionRange(
                        ApiKey::LEADER_AND_ISR,
                        0,
                        7,
                    ),
                    new ApiVersionRange(
                        ApiKey::STOP_REPLICA,
                        0,
                        4,
                    ),
                    new ApiVersionRange(
                        ApiKey::UPDATE_METADATA,
                        0,
                        8,
                    ),
                    new ApiVersionRange(
                        ApiKey::CONTROLLED_SHUTDOWN,
                        0,
                        3,
                    ),
                    new ApiVersionRange(
                        ApiKey::OFFSET_COMMIT,
                        0,
                        9,
                    ),
                    new ApiVersionRange(
                        ApiKey::OFFSET_FETCH,
                        0,
                        9,
                    ),
                    new ApiVersionRange(
                        ApiKey::FIND_COORDINATOR,
                        0,
                        4,
                    ),
                    new ApiVersionRange(
                        ApiKey::JOIN_GROUP,
                        0,
                        9,
                    ),
                    new ApiVersionRange(
                        ApiKey::HEARTBEAT,
                        0,
                        4,
                    ),
                    new ApiVersionRange(
                        ApiKey::LEAVE_GROUP,
                        0,
                        5,
                    ),
                    new ApiVersionRange(
                        ApiKey::SYNC_GROUP,
                        0,
                        5,
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_GROUPS,
                        0,
                        5,
                    ),
                    new ApiVersionRange(
                        ApiKey::LIST_GROUPS,
                        0,
                        4,
                    ),
                    new ApiVersionRange(
                        ApiKey::SASL_HANDSHAKE,
                        0,
                        1,
                    ),
                    new ApiVersionRange(
                        ApiKey::API_VERSIONS,
                        0,
                        3,
                    ),
                    new ApiVersionRange(
                        ApiKey::CREATE_TOPICS,
                        0,
                        7,
                    ),
                    new ApiVersionRange(
                        ApiKey::DELETE_TOPICS,
                        0,
                        6,
                    ),
                    new ApiVersionRange(
                        ApiKey::DELETE_RECORDS,
                        0,
                        2,
                    ),
                    new ApiVersionRange(
                        ApiKey::INIT_PRODUCER_ID,
                        0,
                        4,
                    ),
                    new ApiVersionRange(
                        ApiKey::OFFSET_FOR_LEADER_EPOCH,
                        0,
                        4,
                    ),
                    new ApiVersionRange(
                        ApiKey::ADD_PARTITIONS_TO_TXN,
                        0,
                        4,
                    ),
                    new ApiVersionRange(
                        ApiKey::ADD_OFFSETS_TO_TXN,
                        0,
                        3,
                    ),
                    new ApiVersionRange(
                        ApiKey::END_TXN,
                        0,
                        3,
                    ),
                    new ApiVersionRange(
                        ApiKey::WRITE_TXN_MARKERS,
                        0,
                        1,
                    ),
                    new ApiVersionRange(
                        ApiKey::TXN_OFFSET_COMMIT,
                        0,
                        3,
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_ACLS,
                        0,
                        3,
                    ),
                    new ApiVersionRange(
                        ApiKey::CREATE_ACLS,
                        0,
                        3,
                    ),
                    new ApiVersionRange(
                        ApiKey::DELETE_ACLS,
                        0,
                        3,
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_CONFIGS,
                        0,
                        4,
                    ),
                    new ApiVersionRange(
                        ApiKey::ALTER_CONFIGS,
                        0,
                        2,
                    ),
                    new ApiVersionRange(
                        ApiKey::ALTER_REPLICA_LOG_DIRS,
                        0,
                        2,
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_LOG_DIRS,
                        0,
                        4,
                    ),
                    new ApiVersionRange(
                        ApiKey::SASL_AUTHENTICATE,
                        0,
                        2,
                    ),
                    new ApiVersionRange(
                        ApiKey::CREATE_PARTITIONS,
                        0,
                        3,
                    ),
                    new ApiVersionRange(
                        ApiKey::CREATE_DELEGATION_TOKEN,
                        0,
                        3,
                    ),
                    new ApiVersionRange(
                        ApiKey::RENEW_DELEGATION_TOKEN,
                        0,
                        2,
                    ),
                    new ApiVersionRange(
                        ApiKey::EXPIRE_DELEGATION_TOKEN,
                        0,
                        2,
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_DELEGATION_TOKEN,
                        0,
                        3,
                    ),
                    new ApiVersionRange(
                        ApiKey::DELETE_GROUPS,
                        0,
                        2,
                    ),
                    new ApiVersionRange(
                        ApiKey::ELECT_LEADERS,
                        0,
                        2,
                    ),
                    new ApiVersionRange(
                        ApiKey::INCREMENTAL_ALTER_CONFIGS,
                        0,
                        1,
                    ),
                    new ApiVersionRange(
                        ApiKey::ALTER_PARTITION_REASSIGNMENTS,
                        0,
                        0,
                    ),
                    new ApiVersionRange(
                        ApiKey::LIST_PARTITION_REASSIGNMENTS,
                        0,
                        0,
                    ),
                    new ApiVersionRange(
                        ApiKey::OFFSET_DELETE,
                        0,
                        0,
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_CLIENT_QUOTAS,
                        0,
                        1,
                    ),
                    new ApiVersionRange(
                        ApiKey::ALTER_CLIENT_QUOTAS,
                        0,
                        1,
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_USER_SCRAM_CREDENTIALS,
                        0,
                        0,
                    ),
                    new ApiVersionRange(
                        ApiKey::ALTER_USER_SCRAM_CREDENTIALS,
                        0,
                        0,
                    ),
                    new ApiVersionRange(
                        ApiKey::ALTER_PARTITION,
                        0,
                        3,
                    ),
                    new ApiVersionRange(
                        ApiKey::UPDATE_FEATURES,
                        0,
                        1,
                    ),
                    new ApiVersionRange(
                        ApiKey::ENVELOPE,
                        0,
                        0,
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_CLUSTER,
                        0,
                        1,
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_PRODUCERS,
                        0,
                        0,
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_TRANSACTIONS,
                        0,
                        0,
                    ),
                    new ApiVersionRange(
                        ApiKey::LIST_TRANSACTIONS,
                        0,
                        0,
                    ),
                    new ApiVersionRange(
                        ApiKey::ALLOCATE_PRODUCER_IDS,
                        0,
                        0,
                    ),
                    new ApiVersionRange(
                        ApiKey::CONSUMER_GROUP_HEARTBEAT,
                        0,
                        0,
                    ),
                ],
                0,
            ),
        ];
    }

    #[DataProvider('fixtures')]
    public function testApiVersions(ApiVersion $version, ApiVersionsResponse $response): void
    {
        $connection = $this->roundTrip(
            \sprintf('/api_versions/v%s.txt', $version->value),
        );

        self::assertEquals(
            $response,
            $connection->apiVersions()->await(),
        );
    }
}
