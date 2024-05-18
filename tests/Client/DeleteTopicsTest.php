<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Tests\Client;

use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Command;
use Kafkiansky\Kratos\Internal\Protocol\DeleteTopics\DeleteTopicsRequest;
use Kafkiansky\Kratos\Internal\Protocol\DeleteTopics\DeleteTopicsResponse;
use Kafkiansky\Kratos\Internal\Protocol\Error;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;

#[CoversClass(DeleteTopicsRequest::class)]
#[CoversClass(DeleteTopicsResponse::class)]
final class DeleteTopicsTest extends ConnectionTestCase
{
    public static function fixtures(): iterable
    {
        yield 'v1' => [
            ApiVersion::V1,
            new DeleteTopicsResponse(
                topicErrors: ['events' => Error::NONE],
            ),
        ];
    }

    #[DataProvider('fixtures')]
    public function testDeleteTopics(ApiVersion $version, DeleteTopicsResponse $response): void
    {
        $connection = $this->roundTrip(
            \sprintf('/delete_topics/v%s.txt', $version->value),
        );

        self::assertEquals(
            $response,
            $connection->request(Command::deleteTopics(['events']), $version)->await(),
        );
    }
}
