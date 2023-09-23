<?php

declare(strict_types=1);

namespace Devnix\React\ServiceBus;

use React\Promise\PromiseInterface;

use function React\Promise\resolve;

final class ServiceBus implements ServiceBusInterface
{
    private \Closure $middlewareChain;

    public function __construct(
        MiddlewareInterface ...$middleware,
    ) {
        $this->middlewareChain = $this->createExecutionChain(...$middleware);
    }

    public function dispatch(object $command): PromiseInterface
    {
        return ($this->middlewareChain)($command);
    }

    private function createExecutionChain(MiddlewareInterface ...$middlewareList): \Closure
    {
        $lastCallable = static fn (object $command): PromiseInterface => resolve(null);

        while ($middleware = array_pop($middlewareList)) {
            $lastCallable = static fn (object $command) => $middleware->__invoke($command, $lastCallable);
        }

        return $lastCallable;
    }
}
