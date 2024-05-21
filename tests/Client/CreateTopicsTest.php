<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Tests\Client;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Command;
use Kafkiansky\Kratos\Internal\Protocol\CreateTopics\CreateTopicsRequest;
use Kafkiansky\Kratos\Internal\Protocol\CreateTopics\CreateTopicsResponse;
use Kafkiansky\Kratos\Internal\Protocol\CreateTopics\TopicDetail;
use Kafkiansky\Kratos\Internal\Protocol\CreateTopics\TopicError;
use Kafkiansky\Kratos\Internal\Protocol\Error;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(CreateTopicsRequest::class)]
#[CoversClass(CreateTopicsResponse::class)]
final class CreateTopicsTest extends ConnectionTestCase
{
    /**
     * @return iterable<array-key, array{ApiVersion, CreateTopicsResponse}>
     */
    public static function fixtures(): iterable
    {
        yield 'v1' => [
            new ApiVersion(1),
            new CreateTopicsResponse(
                topicErrors: [
                    'analytics' => new TopicError(
                        Error::NONE,
                    ),
                ],
            ),
        ];
    }

    #[DataProvider('fixtures')]
    public function testCreateTopics(ApiVersion $version, CreateTopicsResponse $response): void
    {
        $connection = $this->roundTrip(
            \sprintf('/create_topics/v%s.txt', $version->value),
        );

        self::assertEquals(
            $response,
            $connection->request(Command::createTopics(['analytics' => new TopicDetail(2, 2)]), $version)->await(),
        );
    }
}
