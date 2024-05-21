<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

interface WriteBuffer
{
    public function write(string $bytes): self;

    public function writeString(?string $value = null): self;

    public function writeNullableString(?string $value = null): self;

    public function writeCompactString(string $v): self;

    public function writeNullableCompactString(?string $v = null): self;

    public function writeEmptyTaggedFieldArray(): self;

    /**
     * @template TKey of array-key
     * @template TValue
     *
     * @param array<TKey, TValue>                $items
     * @param callable(self, TKey, TValue): void $writer
     * @param ?callable(int): void               $writeLength
     */
    public function writeMap(array $items, callable $writer, ?callable $writeLength = null): self;

    /**
     * @template T
     *
     * @param T[]                     $items
     * @param callable(self, T): void $writer
     * @param ?callable(int): void    $writeLength
     */
    public function writeArray(array $items, callable $writer, ?callable $writeLength = null): self;

    public function writeArrayLength(int $value): self;

    public function writeCompactArrayLength(int $value): self;

    public function writeBool(bool $v): self;

    public function writeInt16(int $value): self;

    public function writeInt32(int $value): self;
}
