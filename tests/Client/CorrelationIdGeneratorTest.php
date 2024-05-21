<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Tests\Client;

use Kafkiansky\Kratos\Internal\Client\CorrelationIdGenerator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CorrelationIdGenerator::class)]
final class CorrelationIdGeneratorTest extends TestCase
{
    public function testNext(): void
    {
        $generator = new CorrelationIdGenerator();

        for ($i = 0; $i < 100; ++$i) {
            self::assertSame($i + 1, $generator->next());
        }
    }
}
