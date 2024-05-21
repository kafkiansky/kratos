<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Tests\Client;

use Kafkiansky\Kratos\Internal\Protocol\ApiKey;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersions\ApiVersionRange;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersions\ApiVersionsRequest;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersions\ApiVersionsResponse;
use Kafkiansky\Kratos\Internal\Protocol\Command;
use Kafkiansky\Kratos\Internal\Protocol\Error;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(ApiVersionsRequest::class)]
#[CoversClass(ApiVersionsResponse::class)]
final class ApiVersionsTest extends ConnectionTestCase
{
    /**
     * @return iterable<array-key, array{ApiVersion, ApiVersionsResponse}>
     */
    public static function fixtures(): iterable
    {
        yield 'v3' => [
            new ApiVersion(3),
            new ApiVersionsResponse(
                Error::NONE,
                [
                    new ApiVersionRange(
                        ApiKey::PRODUCE,
                        new ApiVersion(0),
                        new ApiVersion(10),
                    ),
                    new ApiVersionRange(
                        ApiKey::FETCH,
                        new ApiVersion(0),
                        new ApiVersion(16),
                    ),
                    new ApiVersionRange(
                        ApiKey::LIST_OFFSETS,
                        new ApiVersion(0),
                        new ApiVersion(8),
                    ),
                    new ApiVersionRange(
                        ApiKey::METADATA,
                        new ApiVersion(0),
                        new ApiVersion(12),
                    ),
                    new ApiVersionRange(
                        ApiKey::LEADER_AND_ISR,
                        new ApiVersion(0),
                        new ApiVersion(7),
                    ),
                    new ApiVersionRange(
                        ApiKey::STOP_REPLICA,
                        new ApiVersion(0),
                        new ApiVersion(4),
                    ),
                    new ApiVersionRange(
                        ApiKey::UPDATE_METADATA,
                        new ApiVersion(0),
                        new ApiVersion(8),
                    ),
                    new ApiVersionRange(
                        ApiKey::CONTROLLED_SHUTDOWN,
                        new ApiVersion(0),
                        new ApiVersion(3),
                    ),
                    new ApiVersionRange(
                        ApiKey::OFFSET_COMMIT,
                        new ApiVersion(0),
                        new ApiVersion(9),
                    ),
                    new ApiVersionRange(
                        ApiKey::OFFSET_FETCH,
                        new ApiVersion(0),
                        new ApiVersion(9),
                    ),
                    new ApiVersionRange(
                        ApiKey::FIND_COORDINATOR,
                        new ApiVersion(0),
                        new ApiVersion(4),
                    ),
                    new ApiVersionRange(
                        ApiKey::JOIN_GROUP,
                        new ApiVersion(0),
                        new ApiVersion(9),
                    ),
                    new ApiVersionRange(
                        ApiKey::HEARTBEAT,
                        new ApiVersion(0),
                        new ApiVersion(4),
                    ),
                    new ApiVersionRange(
                        ApiKey::LEAVE_GROUP,
                        new ApiVersion(0),
                        new ApiVersion(5),
                    ),
                    new ApiVersionRange(
                        ApiKey::SYNC_GROUP,
                        new ApiVersion(0),
                        new ApiVersion(5),
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_GROUPS,
                        new ApiVersion(0),
                        new ApiVersion(5),
                    ),
                    new ApiVersionRange(
                        ApiKey::LIST_GROUPS,
                        new ApiVersion(0),
                        new ApiVersion(4),
                    ),
                    new ApiVersionRange(
                        ApiKey::SASL_HANDSHAKE,
                        new ApiVersion(0),
                        new ApiVersion(1),
                    ),
                    new ApiVersionRange(
                        ApiKey::API_VERSIONS,
                        new ApiVersion(0),
                        new ApiVersion(3),
                    ),
                    new ApiVersionRange(
                        ApiKey::CREATE_TOPICS,
                        new ApiVersion(0),
                        new ApiVersion(7),
                    ),
                    new ApiVersionRange(
                        ApiKey::DELETE_TOPICS,
                        new ApiVersion(0),
                        new ApiVersion(6),
                    ),
                    new ApiVersionRange(
                        ApiKey::DELETE_RECORDS,
                        new ApiVersion(0),
                        new ApiVersion(2),
                    ),
                    new ApiVersionRange(
                        ApiKey::INIT_PRODUCER_ID,
                        new ApiVersion(0),
                        new ApiVersion(4),
                    ),
                    new ApiVersionRange(
                        ApiKey::OFFSET_FOR_LEADER_EPOCH,
                        new ApiVersion(0),
                        new ApiVersion(4),
                    ),
                    new ApiVersionRange(
                        ApiKey::ADD_PARTITIONS_TO_TXN,
                        new ApiVersion(0),
                        new ApiVersion(4),
                    ),
                    new ApiVersionRange(
                        ApiKey::ADD_OFFSETS_TO_TXN,
                        new ApiVersion(0),
                        new ApiVersion(3),
                    ),
                    new ApiVersionRange(
                        ApiKey::END_TXN,
                        new ApiVersion(0),
                        new ApiVersion(3),
                    ),
                    new ApiVersionRange(
                        ApiKey::WRITE_TXN_MARKERS,
                        new ApiVersion(0),
                        new ApiVersion(1),
                    ),
                    new ApiVersionRange(
                        ApiKey::TXN_OFFSET_COMMIT,
                        new ApiVersion(0),
                        new ApiVersion(3),
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_ACLS,
                        new ApiVersion(0),
                        new ApiVersion(3),
                    ),
                    new ApiVersionRange(
                        ApiKey::CREATE_ACLS,
                        new ApiVersion(0),
                        new ApiVersion(3),
                    ),
                    new ApiVersionRange(
                        ApiKey::DELETE_ACLS,
                        new ApiVersion(0),
                        new ApiVersion(3),
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_CONFIGS,
                        new ApiVersion(0),
                        new ApiVersion(4),
                    ),
                    new ApiVersionRange(
                        ApiKey::ALTER_CONFIGS,
                        new ApiVersion(0),
                        new ApiVersion(2),
                    ),
                    new ApiVersionRange(
                        ApiKey::ALTER_REPLICA_LOG_DIRS,
                        new ApiVersion(0),
                        new ApiVersion(2),
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_LOG_DIRS,
                        new ApiVersion(0),
                        new ApiVersion(4),
                    ),
                    new ApiVersionRange(
                        ApiKey::SASL_AUTHENTICATE,
                        new ApiVersion(0),
                        new ApiVersion(2),
                    ),
                    new ApiVersionRange(
                        ApiKey::CREATE_PARTITIONS,
                        new ApiVersion(0),
                        new ApiVersion(3),
                    ),
                    new ApiVersionRange(
                        ApiKey::CREATE_DELEGATION_TOKEN,
                        new ApiVersion(0),
                        new ApiVersion(3),
                    ),
                    new ApiVersionRange(
                        ApiKey::RENEW_DELEGATION_TOKEN,
                        new ApiVersion(0),
                        new ApiVersion(2),
                    ),
                    new ApiVersionRange(
                        ApiKey::EXPIRE_DELEGATION_TOKEN,
                        new ApiVersion(0),
                        new ApiVersion(2),
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_DELEGATION_TOKEN,
                        new ApiVersion(0),
                        new ApiVersion(3),
                    ),
                    new ApiVersionRange(
                        ApiKey::DELETE_GROUPS,
                        new ApiVersion(0),
                        new ApiVersion(2),
                    ),
                    new ApiVersionRange(
                        ApiKey::ELECT_LEADERS,
                        new ApiVersion(0),
                        new ApiVersion(2),
                    ),
                    new ApiVersionRange(
                        ApiKey::INCREMENTAL_ALTER_CONFIGS,
                        new ApiVersion(0),
                        new ApiVersion(1),
                    ),
                    new ApiVersionRange(
                        ApiKey::ALTER_PARTITION_REASSIGNMENTS,
                        new ApiVersion(0),
                        new ApiVersion(0),
                    ),
                    new ApiVersionRange(
                        ApiKey::LIST_PARTITION_REASSIGNMENTS,
                        new ApiVersion(0),
                        new ApiVersion(0),
                    ),
                    new ApiVersionRange(
                        ApiKey::OFFSET_DELETE,
                        new ApiVersion(0),
                        new ApiVersion(0),
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_CLIENT_QUOTAS,
                        new ApiVersion(0),
                        new ApiVersion(1),
                    ),
                    new ApiVersionRange(
                        ApiKey::ALTER_CLIENT_QUOTAS,
                        new ApiVersion(0),
                        new ApiVersion(1),
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_USER_SCRAM_CREDENTIALS,
                        new ApiVersion(0),
                        new ApiVersion(0),
                    ),
                    new ApiVersionRange(
                        ApiKey::ALTER_USER_SCRAM_CREDENTIALS,
                        new ApiVersion(0),
                        new ApiVersion(0),
                    ),
                    new ApiVersionRange(
                        ApiKey::ALTER_PARTITION,
                        new ApiVersion(0),
                        new ApiVersion(3),
                    ),
                    new ApiVersionRange(
                        ApiKey::UPDATE_FEATURES,
                        new ApiVersion(0),
                        new ApiVersion(1),
                    ),
                    new ApiVersionRange(
                        ApiKey::ENVELOPE,
                        new ApiVersion(0),
                        new ApiVersion(0),
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_CLUSTER,
                        new ApiVersion(0),
                        new ApiVersion(1),
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_PRODUCERS,
                        new ApiVersion(0),
                        new ApiVersion(0),
                    ),
                    new ApiVersionRange(
                        ApiKey::DESCRIBE_TRANSACTIONS,
                        new ApiVersion(0),
                        new ApiVersion(0),
                    ),
                    new ApiVersionRange(
                        ApiKey::LIST_TRANSACTIONS,
                        new ApiVersion(0),
                        new ApiVersion(0),
                    ),
                    new ApiVersionRange(
                        ApiKey::ALLOCATE_PRODUCER_IDS,
                        new ApiVersion(0),
                        new ApiVersion(0),
                    ),
                    new ApiVersionRange(
                        ApiKey::CONSUMER_GROUP_HEARTBEAT,
                        new ApiVersion(0),
                        new ApiVersion(0),
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
            $connection->request(Command::apiVersions(), $version)->await(),
        );
    }
}
