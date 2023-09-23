<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus;

use React\Promise;

interface MiddlewareInterface
{
    /**
     * @return Promise\PromiseInterface<mixed>
     */
    public function __invoke(object $command, callable $next): Promise\PromiseInterface;
}
