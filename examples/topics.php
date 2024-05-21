<?php

declare(strict_types=1);

use Amp\Dns\BlockingFallbackDnsResolver;
use Amp\Socket\DnsSocketConnector;
use Amp\Socket\RetrySocketConnector;
use Kafkiansky\Kratos;

require __DIR__ . '/../vendor/autoload.php';
$size = 10;
$size = 2;
dd($size);

$connector = new RetrySocketConnector(
    new DnsSocketConnector(
        new BlockingFallbackDnsResolver(),
    ),
);

$cluster = Kratos\Cluster::fromConnectionOptions(
    new Kratos\ConnectionOptions(
        ['tcp://broker0:9092', 'tcp://broker1:9092'],
        connector: $connector->connect(...),
    ),
);

$cluster->controller()->deleteTopics(['events']);
