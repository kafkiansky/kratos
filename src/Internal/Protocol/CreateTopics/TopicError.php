<?php

declare(strict_types=1);

namespace Kafkiansky\Kratos\Internal\Protocol\CreateTopics;

use Kafkiansky\Kratos\Internal\Protocol\Error;

final readonly class TopicError
{
    public function __construct(
        public Error $error,
        public ?string $message = null,
    ) {
    }
}
