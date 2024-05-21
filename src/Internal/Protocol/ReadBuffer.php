<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol;

interface ReadBuffer
{
    /**
     * @template TKey of array-key
     * @template TValue
     *
     * @param callable(self): \Generator<TKey, TValue> $read
     *
     * @throws \Kafkiansky\Binary\BinaryException
     *
     * @return \Generator<TKey, TValue>
     */
    public function consumeGenerator(callable $read): \Generator;

    /**
     * @template T
     *
     * @param callable(self): T $read
     *
     * @throws \Kafkiansky\Binary\BinaryException
     *
     * @return \Generator<T>
     */
    public function consumeArrayIterator(callable $read): \Generator;

    /**
     * @template T
     *
     * @param callable(self): T $read
     *
     * @throws \Kafkiansky\Binary\BinaryException
     *
     * @return \Generator<T>
     */
    public function consumeCompactArrayIterator(callable $read): \Generator;

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function consumeError(): Error;

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function consumeApiKey(): ApiKey;

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function consumeCompactArrayLength(): int;

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function consumeArrayLength(): int;

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function consumeEmptyTaggedFieldArray(): void;

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function consumeBool(): bool;

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function consumeInt16(): int;

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function consumeInt32(): int;

    /**
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function consumeString(): string;

    public function consumeCompactString(): string;

    /**
     * @param positive-int $length
     *
     * @throws \Kafkiansky\Binary\BinaryException
     */
    public function consumeBytes(int $length): string;
}
