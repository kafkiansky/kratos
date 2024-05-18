<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\ApiVersions;

use Kafkiansky\Kratos\Internal\Protocol\ApiKey;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Buffer;
use Kafkiansky\Kratos\Internal\Protocol\Request;

/**
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

    public function write(Buffer $buffer, ApiVersion $version): void
    {
        if ($version->gte(ApiVersion::V3)) {
            $buffer
                ->writeCompactString($this->clientSoftwareName ?: ' ')
                ->writeCompactString($this->clientSoftwareVersion ?: ' ')
                ->writeEmptyTaggedFieldArray()
            ;
        }
    }
}
