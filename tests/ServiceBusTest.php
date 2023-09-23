<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Tests;

use PHPUnit\Framework;
use React\Async;
use React\Promise;
use ReactServiceBus\ServiceBus;

#[Framework\Attributes\CoversClass(\ReactServiceBus\ServiceBus\ServiceBus::class)]
final class ServiceBusTest extends Framework\TestCase
{
    public function test_all_middleware_are_executed_and_return_values_are_respected(): void
    {
        /** @var list<int> $executionOrder */
        $executionOrder = [];

        $middleware1 = new class($executionOrder) implements ServiceBus\MiddlewareInterface {
            /** @param list<int> $executionOrder */
            public function __construct(private array &$executionOrder) // @phpstan-ignore-line
            {
            }

            public function __invoke(object $command, callable $next): Promise\PromiseInterface
            {
                $this->executionOrder[] = 1;

                return $next($command);
            }
        };
        $middleware2 = new class($executionOrder) implements ServiceBus\MiddlewareInterface {
            /** @param list<int> $executionOrder */
            public function __construct(private array &$executionOrder) // @phpstan-ignore-line
            {
            }

            public function __invoke(object $command, callable $next): Promise\PromiseInterface
            {
                $this->executionOrder[] = 2;

                return $next($command);
            }
        };
        $middleware3 = new class($executionOrder) implements ServiceBus\MiddlewareInterface {
            /** @param list<int> $executionOrder */
            public function __construct(private array &$executionOrder) // @phpstan-ignore-line
            {
            }

            public function __invoke(object $command, callable $next): Promise\PromiseInterface
            {
                $this->executionOrder[] = 3;

                return Promise\resolve('foobar');
            }
        };

        $serviceBus = new ServiceBus\ServiceBus($middleware1, $middleware2, $middleware3);
        $result = Async\await($serviceBus->dispatch(new ServiceBus\Tests\Fixtures\Command\AddTaskCommand()));

        self::assertEquals('foobar', $result);
        self::assertEquals([1, 2, 3], $executionOrder);
    }

    public function test_single_middleware_works(): void
    {
        $middleware = new class() implements ServiceBus\MiddlewareInterface {
            public function __invoke(object $command, callable $next): Promise\PromiseInterface
            {
                return Promise\resolve('foobar');
            }
        };

        $serviceBus = new ServiceBus\ServiceBus($middleware);
        $result = Async\await($serviceBus->dispatch(new ServiceBus\Tests\Fixtures\Command\AddTaskCommand()));

        self::assertEquals('foobar', $result);
    }

    public function test_no_middleware_perform_a_safe_noop(): void
    {
        $serviceBus = new ServiceBus\ServiceBus();
        Async\await($serviceBus->dispatch(new ServiceBus\Tests\Fixtures\Command\AddTaskCommand()));

        $this->addToAssertionCount(1);
    }
}
