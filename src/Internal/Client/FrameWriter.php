<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Client;

use Amp\Socket\Socket;
use Kafkiansky\Binary\BinaryException;
use Kafkiansky\Kratos\Internal\Protocol;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Buffer;
use Kafkiansky\Kratos\Internal\Protocol\Request;

/**
 * @phpstan-import-type CorrelationId from CorrelationIdGenerator
 */
final readonly class FrameWriter
{
    private Protocol\Buffer $buffer;

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function __construct(
        private ?string $clientId = null,
    ) {
        $this->buffer = Protocol\Buffer::zeroed();
    }

    /**
     * @template T of Protocol\Response
     *
     * @param Protocol\Request<T> $request
     * @param CorrelationId       $correlationId
     *
     * @throws BinaryException
     */
    public function append(Protocol\Request $request, Protocol\ApiVersion $version, int $correlationId): void
    {
        $buffer = Buffer::zeroed();

        $buffer
            ->writeApiKey($request::apiKey())
            ->writeApiVersion($version)
            ->writeCorrelationId($correlationId)
        ;

        $headerVersion = self::headerVersion($request::class, $version);

        if ($headerVersion->gte(ApiVersion::V1)) {
            $buffer->writeString($this->clientId);
        }

        if ($headerVersion->gte(ApiVersion::V2)) {
            $buffer->writeEmptyTaggedFieldArray();
        }

        $request->write($buffer, $version);

        $bytes = $buffer->flush();

        $this->buffer
            ->writeInt32(\strlen($bytes))
            ->write($bytes)
        ;
    }

    /**
     * @throws \Amp\ByteStream\ClosedException
     * @throws \Amp\ByteStream\StreamException
     */
    public function write(Socket $socket): void
    {
        $socket->write($this->buffer->flush());
    }

    /**
     * @template T of Request
     *
     * @param class-string<T> $request
     */
    private static function headerVersion(string $request, ApiVersion $version): ApiVersion
    {
        return match ($request) {
            Protocol\Metadata\MetadataRequest::class => match (true) {
                $version->gte(ApiVersion::V9) => ApiVersion::V2,
                default => ApiVersion::V1,
            },
            Protocol\ApiVersions\ApiVersionsRequest::class => match (true) {
                $version->gte(ApiVersion::V3) => ApiVersion::V2,
                default => ApiVersion::V1,
            },
            Protocol\CreateTopics\CreateTopicsRequest::class, Protocol\DeleteTopics\DeleteTopicsRequest::class => ApiVersion::V1,
            default => $version,
        };
    }
}
