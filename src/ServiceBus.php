<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus;

use React\Promise;

final class ServiceBus implements ServiceBusInterface
{
    private \Closure $middlewareChain;

    public function __construct(
        MiddlewareInterface ...$middleware,
    ) {
        $this->middlewareChain = $this->createExecutionChain(...$middleware);
    }

    public function dispatch(object $command): Promise\PromiseInterface
    {
        return ($this->middlewareChain)($command);
    }

    private function createExecutionChain(MiddlewareInterface ...$middlewareList): \Closure
    {
        $lastCallable = static fn (object $command): Promise\PromiseInterface => Promise\resolve(null);

        while ($middleware = array_pop($middlewareList)) {
            $lastCallable = static fn (object $command) => $middleware->__invoke($command, $lastCallable);
        }

        return $lastCallable;
    }
}
