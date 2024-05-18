<?php

declare(strict_types=1);

use Amp\Dns\BlockingFallbackDnsResolver;
use Amp\Socket\DnsSocketConnector;
use Amp\Socket\RetrySocketConnector;
use Kafkiansky\Kratos;

require __DIR__ . '/../vendor/autoload.php';

$connector = new RetrySocketConnector(
    new DnsSocketConnector(
        new BlockingFallbackDnsResolver(),
    ),
);

$socket = $connector->connect('tcp://broker0:9092');

$connection = new Kratos\Internal\Client\Connection($socket);

var_dump(
    $connection->fetchMetadata(Kratos\Internal\Protocol\ApiVersion::V0)->await(),
);

