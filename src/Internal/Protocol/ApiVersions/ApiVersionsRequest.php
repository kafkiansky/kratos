<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\ApiVersions;

use Kafkiansky\Kratos\Internal\Protocol\ApiKey;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\WriteBuffer;
use Kafkiansky\Kratos\Internal\Protocol\Request;

/**
 * @see https://kafka.apache.org/protocol.html#The_Messages_ApiVersions
 *
 * @template-implements Request<ApiVersionsResponse>
 */
final readonly class ApiVersionsRequest implements Request
{
    public function __construct(
        private ?string $clientSoftwareName = null,
        private ?string $clientSoftwareVersion = null,
    ) {
    }

    public static function apiKey(): ApiKey
    {
        return ApiKey::API_VERSIONS;
    }

    /**
     * {@inheritdoc}
     */
    public static function responseType(): string
    {
        return ApiVersionsResponse::class;
    }

    public function write(WriteBuffer $buffer, ApiVersion $version): void
    {
        if ($version->gte(new ApiVersion(3))) {
            $buffer
                ->writeCompactString($this->clientSoftwareName ?: ' ')
                ->writeCompactString($this->clientSoftwareVersion ?: ' ')
                ->writeEmptyTaggedFieldArray()
            ;
        }
    }
}
