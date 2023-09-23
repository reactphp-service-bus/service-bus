<?php

declare(strict_types=1);

namespace Devnix\React\ServiceBus;

use React\Promise\PromiseInterface;

interface MiddlewareInterface
{
    /**
     * @return PromiseInterface<mixed>
     */
    public function __invoke(object $command, callable $next): PromiseInterface;
}
