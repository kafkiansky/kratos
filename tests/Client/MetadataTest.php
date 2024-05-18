<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Tests\Client;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Command;
use Kafkiansky\Kratos\Internal\Protocol\Error;
use Kafkiansky\Kratos\Internal\Protocol\Metadata\Broker;
use Kafkiansky\Kratos\Internal\Protocol\Metadata\MetadataRequest;
use Kafkiansky\Kratos\Internal\Protocol\Metadata\MetadataResponse;
use Kafkiansky\Kratos\Internal\Protocol\Metadata\PartitionMetadata;
use Kafkiansky\Kratos\Internal\Protocol\Metadata\TopicMetadata;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(MetadataRequest::class)]
#[CoversClass(MetadataResponse::class)]
final class MetadataTest extends ConnectionTestCase
{
    public static function fixtures(): iterable
    {
        yield 'v0' => [
            ApiVersion::V0,
            new MetadataResponse(
                [
                    new Broker(
                        0,
                        '7401e2d26edf',
                        9092,
                    ),
                    new Broker(
                        1,
                        '265d81453fd6',
                        9092,
                    ),
                ],
                [
                    new TopicMetadata(
                        Error::NONE,
                        'events',
                        [
                            new PartitionMetadata(
                                Error::NONE,
                                0,
                                0,
                                0,
                                [0, 1],
                                [0, 1],
                            ),
                            new PartitionMetadata(
                                Error::NONE,
                                1,
                                1,
                                0,
                                [1, 0],
                                [1, 0],
                            ),
                        ],
                    ),
                ],
            ),
        ];
    }

    #[DataProvider('fixtures')]
    public function testFetchMetadata(ApiVersion $version, MetadataResponse $response): void
    {
        $connection = $this->roundTrip(
            \sprintf('/metadata/v%s.txt', $version->value),
        );

        self::assertEquals(
            $response,
            $connection->request(Command::fetchMetadata(), $version)->await(),
        );
    }
}
