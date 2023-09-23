<?php

declare(strict_types=1);

namespace Devnix\React\ServiceBus\Tests;

use Devnix\React\ServiceBus\MiddlewareInterface;
use Devnix\React\ServiceBus\ServiceBus;
use Devnix\React\ServiceBus\Tests\Fixtures\Command\AddTaskCommand;
use PHPUnit\Framework;
use React\Promise\PromiseInterface;

use function React\Async\await;
use function React\Promise\resolve;

#[Framework\Attributes\CoversClass(\Devnix\React\ServiceBus\ServiceBus::class)]
final class ServiceBusTest extends Framework\TestCase
{
    public function test_all_middleware_are_executed_and_return_values_are_respected(): void
    {
        /** @var list<int> $executionOrder */
        $executionOrder = [];

        $middleware1 = new class($executionOrder) implements MiddlewareInterface {
            /** @param list<int> $executionOrder */
            public function __construct(private array &$executionOrder) // @phpstan-ignore-line
            {
            }

            public function __invoke(object $command, callable $next): PromiseInterface
            {
                $this->executionOrder[] = 1;

                return $next($command);
            }
        };
        $middleware2 = new class($executionOrder) implements MiddlewareInterface {
            /** @param list<int> $executionOrder */
            public function __construct(private array &$executionOrder) // @phpstan-ignore-line
            {
            }

            public function __invoke(object $command, callable $next): PromiseInterface
            {
                $this->executionOrder[] = 2;

                return $next($command);
            }
        };
        $middleware3 = new class($executionOrder) implements MiddlewareInterface {
            /** @param list<int> $executionOrder */
            public function __construct(private array &$executionOrder) // @phpstan-ignore-line
            {
            }

            public function __invoke(object $command, callable $next): PromiseInterface
            {
                $this->executionOrder[] = 3;

                return resolve('foobar');
            }
        };

        $serviceBus = new ServiceBus($middleware1, $middleware2, $middleware3);
        $result = await($serviceBus->dispatch(new AddTaskCommand()));

        self::assertEquals('foobar', $result);
        self::assertEquals([1, 2, 3], $executionOrder);
    }

    public function test_single_middleware_works(): void
    {
        $middleware = new class() implements MiddlewareInterface {
            public function __invoke(object $command, callable $next): PromiseInterface
            {
                return resolve('foobar');
            }
        };

        $serviceBus = new ServiceBus($middleware);
        $result = await($serviceBus->dispatch(new AddTaskCommand()));

        self::assertEquals('foobar', $result);
    }

    public function test_no_middleware_perform_a_safe_noop(): void
    {
        $serviceBus = new ServiceBus();
        await($serviceBus->dispatch(new AddTaskCommand()));

        $this->addToAssertionCount(1);
    }
}
