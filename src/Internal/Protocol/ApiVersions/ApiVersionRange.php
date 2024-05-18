<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\ApiVersions;

use Kafkiansky\Kratos\Internal\Protocol\ApiKey;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Buffer;

final readonly class ApiVersionRange
{
    public function __construct(
        public ApiKey $apiKey,
        public int $minVersion,
        public int $maxVersion,
    ) {
    }

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public static function fromBuffer(Buffer $buffer, ApiVersion $version): self
    {
        $apiKey = $buffer->readApiKey();
        $min = $buffer->consumeInt16();
        $max = $buffer->consumeInt16();

        if ($version->gte(ApiVersion::V3)) {
            $buffer->readEmptyTaggedFieldArray();
        }

        return new self($apiKey, $min, $max);
    }
}
