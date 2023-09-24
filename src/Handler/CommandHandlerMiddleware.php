<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Handler;

use Psr;
use React\Promise;
use ReactServiceBus\ServiceBus;

final class CommandHandlerMiddleware implements ServiceBus\MiddlewareInterface
{
    public function __construct(
        private Psr\Container\ContainerInterface $container,
        private ServiceBus\Handler\Mapping\CommandToHandlerMappingInterface $mapping,
    ) {
    }

    public function __invoke(object $command, callable $next): Promise\PromiseInterface
    {
        $methodToCall = $this->mapping->findHandlerForCommand(get_class($command));

        $handler = $this->container->get($methodToCall->className);

        return $handler->{$methodToCall->methodName}($command);
    }
}
