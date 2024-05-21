<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

use Kafkiansky\Binary\Endianness;

final readonly class Buffer implements
    WriteBuffer,
    ReadBuffer
{
    private function __construct(
        private \Kafkiansky\Binary\Buffer $internal,
    ) {
    }

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public static function zeroed(): self
    {
        return new self(
            \Kafkiansky\Binary\Buffer::empty(Endianness::network()),
        );
    }

    /**
     * @param non-empty-string $bytes
     *
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public static function fromBytes(string $bytes): self
    {
        return new self(
            \Kafkiansky\Binary\Buffer::fromString($bytes, Endianness::network()),
        );
    }

    /**
     * @param positive-int $size
     *
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function cut(int $size): self
    {
        return self::fromBytes(
            $this->internal->consume($size),
        );
    }

    /**
     * @param positive-int $n
     *
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function discard(int $n): void
    {
        $this->internal->consume($n);
    }

    public function size(): int
    {
        return $this->internal->count();
    }

    public function flush(): string
    {
        return $this->internal->reset();
    }

    public function writeInt8(int $value): self
    {
        $this->internal->writeInt8($value);

        return $this;
    }

    public function writeInt16(int $value): self
    {
        $this->internal->writeInt16($value);

        return $this;
    }

    public function writeInt32(int $value): self
    {
        $this->internal->writeInt32($value);

        return $this;
    }

    public function writeUint32(int $value): self
    {
        $this->internal->writeUint32($value);

        return $this;
    }

    public function writeArrayLength(int $value): self
    {
        $this->internal->writeInt32($value);

        return $this;
    }

    public function writeCompactArrayLength(int $value): self
    {
        $this->internal->writeVarUint($value + 1);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function writeMap(array $items, callable $writer, ?callable $writeLength = null): self
    {
        $writeLength ??= $this->writeArrayLength(...);
        $writeLength(\count($items));

        foreach ($items as $key => $value) {
            $writer($this, $key, $value);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function writeArray(array $items, callable $writer, ?callable $writeLength = null): self
    {
        $writeLength ??= $this->writeArrayLength(...);
        $writeLength(\count($items));

        foreach ($items as $item) {
            $writer($this, $item);
        }

        return $this;
    }

    public function writeApiKey(ApiKey $apiKey): self
    {
        $this->writeInt16($apiKey->value);

        return $this;
    }

    public function writeApiVersion(ApiVersion $apiVersion): self
    {
        $this->writeInt16($apiVersion->value);

        return $this;
    }

    public function writeCorrelationId(int $correlationId): self
    {
        $this->writeUint32($correlationId);

        return $this;
    }

    public function write(string $bytes): self
    {
        $this->internal->write($bytes);

        return $this;
    }

    public function writeString(?string $value = null): self
    {
        $value ??= '';

        return $this
            ->writeInt16(\strlen($value))
            ->write($value)
            ;
    }

    public function writeNullableString(?string $value = null): self
    {
        if (null === $value) {
            return $this->writeInt16(-1);
        }

        return $this
            ->writeInt16(\strlen($value))
            ->write($value)
            ;
    }

    public function writeBool(bool $v): self
    {
        return $this->writeInt8($v ? 1 : 0);
    }

    public function writeCompactString(string $v): self
    {
        $this->writeCompactArrayLength(\strlen($v));
        $this->internal->write($v);

        return $this;
    }

    public function writeNullableCompactString(?string $v = null): self
    {
        if (null === $v || 0 === \strlen($v)) {
            $this->writeInt8(0);

            return $this;
        }

        return $this->writeCompactString($v);
    }

    public function writeEmptyTaggedFieldArray(): self
    {
        $this->internal->writeVarUint(0);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function consumeBytes(int $length): string
    {
        return $this->internal->consume($length);
    }

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function consumeInt8(): int
    {
        return $this->internal->consumeInt8();
    }

    /**
     * {@inheritdoc}
     */
    public function consumeString(): string
    {
        /** @phpstan-var -1|positive-int $length */
        $length = $this->consumeInt16();

        return -1 === $length ? '' : $this->internal->consume($length);
    }

    /**
     * {@inheritdoc}
     */
    public function consumeCompactString(): string
    {
        $length = $this->internal->consumeVarUint() - 1;

        return 0 >= $length ? '' : $this->internal->consume($length);
    }

    /**
     * {@inheritdoc}
     */
    public function consumeBool(): bool
    {
        $v = $this->consumeInt8();

        return (bool) $v;
    }

    /**
     * {@inheritdoc}
     */
    public function consumeApiKey(): ApiKey
    {
        return ApiKey::from($this->consumeUint16());
    }

    /**
     * {@inheritdoc}
     */
    public function consumeCompactArrayLength(): int
    {
        $n = $this->internal->consumeVarUint();

        return 0 === $n ? 0 : $n - 1;
    }

    /**
     * {@inheritdoc}
     */
    public function consumeArrayLength(): int
    {
        return $this->internal->consumeUint32();
    }

    /**
     * {@inheritdoc}
     */
    public function consumeEmptyTaggedFieldArray(): void
    {
        $count = $this->internal->consumeVarUint();

        for ($i = 0; $i < $count; $i++) {
            $this->internal->consumeVarUint();
            $n = $this->internal->consumeVarUint();
            if ($n > 0) {
                $this->internal->consume($n);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function consumeInt16(): int
    {
        return $this->internal->consumeInt16();
    }

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function consumeUint16(): int
    {
        return $this->internal->consumeUint16();
    }

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function consumeUint32(): int
    {
        return $this->internal->consumeUint32();
    }

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function readInt32(): int
    {
        return $this->internal->readInt32();
    }

    /**
     * {@inheritdoc}
     */
    public function consumeInt32(): int
    {
        return $this->internal->consumeInt32();
    }

    /**
     * {@inheritdoc}
     */
    public function consumeArrayIterator(callable $read): \Generator
    {
        $len = $this->consumeUint32();

        for ($i = 0; $i < $len; ++$i) {
            yield $read($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function consumeGenerator(callable $read): \Generator
    {
        $len = $this->consumeUint32();

        for ($i = 0; $i < $len; ++$i) {
            yield from $read($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function consumeCompactArrayIterator(callable $read): \Generator
    {
        $len = $this->internal->consumeVarUint();

        for ($i = 0; $i < $len; ++$i) {
            yield $read($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function consumeError(): Error
    {
        return Error::tryFrom($this->consumeInt16()) ?: Error::UNKNOWN_SERVER_ERROR;
    }
}
