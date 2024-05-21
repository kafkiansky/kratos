<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\ApiVersions;

use Kafkiansky\Kratos\Internal\Protocol\ApiKey;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\ReadBuffer;

final readonly class ApiVersionRange
{
    public function __construct(
        public ApiKey $apiKey,
        public ApiVersion $minVersion,
        public ApiVersion $maxVersion,
    ) {
    }

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public static function fromBuffer(ReadBuffer $buffer, ApiVersion $version): self
    {
        $apiKey = $buffer->consumeApiKey();

        /** @var int<0, 32767> $min */
        $min = $buffer->consumeInt16();

        /** @var int<0, 32767> $max */
        $max = $buffer->consumeInt16();

        if ($version->gte(new ApiVersion(3))) {
            $buffer->consumeEmptyTaggedFieldArray();
        }

        return new self(
            $apiKey,
            new ApiVersion($min),
            new ApiVersion($max),
        );
    }
}
