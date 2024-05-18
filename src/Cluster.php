<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos;

use Psl\Collection\MutableVector;
use Psl\Collection\MutableVectorInterface;

final readonly class Cluster
{
    /**
     * @param MutableVectorInterface<Broker> $brokers
     */
    private function __construct(
        private ConnectionOptions $connectionOptions,
        private MutableVectorInterface $brokers = new MutableVector([]),
    ) {}

    public static function fromOptions(ConnectionOptions $connectionOptions): self
    {
        return new self($connectionOptions);
    }

    public function controller(): Broker
    {
        return new Broker();
    }
}
