<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\Metadata;

use Kafkiansky\Kratos\Internal\Protocol\ApiKey;
use Kafkiansky\Kratos\Internal\Protocol\ApiVersion;
use Kafkiansky\Kratos\Internal\Protocol\Buffer;
use Kafkiansky\Kratos\Internal\Protocol\Request;
use Kafkiansky\Kratos\Internal\Protocol\WriteBuffer;

/**
 * @see https://kafka.apache.org/protocol.html#The_Messages_Metadata
 *
 * @template-implements Request<MetadataResponse>
 */
final readonly class MetadataRequest implements Request
{
    /** @var int[]  */
    private const array NULL_UUID = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

    /**
     * @param non-empty-string[] $topics
     */
    public function __construct(
        private array $topics = [],
        private bool $allowTopicAutoCreation = false,
        private bool $includeClusterAuthorizedOperations = false,
        private bool $includeTopicAuthorizedOperations = false,
    ) {
    }

    public function write(WriteBuffer $buffer, ApiVersion $version): void
    {
        if ($version->equals(new ApiVersion(0)) || \count($this->topics) > 0) {
            if ($version->less(new ApiVersion(9))) {
                $buffer->writeArrayLength(\count($this->topics));

                foreach ($this->topics as $topic) {
                    $buffer->writeString($topic);
                }
            } elseif ($version->equals(new ApiVersion(9))) {
                $buffer->writeCompactArrayLength(\count($this->topics));

                foreach ($this->topics as $topic) {
                    $buffer
                        ->writeCompactString($topic)
                        ->writeEmptyTaggedFieldArray()
                    ;
                }
            } else {
                $buffer->writeCompactArrayLength(\count($this->topics));

                foreach ($this->topics as $topic) {
                    $buffer
                        ->write(\implode('', self::NULL_UUID))
                        ->writeNullableCompactString($topic)
                        ->writeEmptyTaggedFieldArray()
                    ;
                }
            }
        } else {
            if ($version->less(new ApiVersion(9))) {
                $buffer->writeInt32(-1);
            } else {
                $buffer->writeCompactArrayLength(-1);
            }
        }

        if ($version->greater(new ApiVersion(3))) {
            $buffer->writeBool($this->allowTopicAutoCreation);
        }

        if ($version->greater(new ApiVersion(7))) {
            $buffer
                ->writeBool($this->includeClusterAuthorizedOperations)
                ->writeBool($this->includeTopicAuthorizedOperations)
            ;
        }

        if ($version->greater(new ApiVersion(8))) {
            $buffer->writeEmptyTaggedFieldArray();
        }
    }

    public static function apiKey(): ApiKey
    {
        return ApiKey::METADATA;
    }

    /**
     * {@inheritdoc}
     */
    public static function responseType(): string
    {
        return MetadataResponse::class;
    }
}
