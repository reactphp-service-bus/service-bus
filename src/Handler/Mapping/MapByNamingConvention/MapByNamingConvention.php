<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Handler\Mapping\MapByNamingConvention;

use ReactServiceBus\ServiceBus\Handler\Mapping\CommandToHandlerMappingInterface;
use ReactServiceBus\ServiceBus\Handler\Mapping\MapByNamingConvention\ClassName\ClassNameInflectorInterface;
use ReactServiceBus\ServiceBus\Handler\Mapping\MapByNamingConvention\Exception\MethodDoesNotExistException;
use ReactServiceBus\ServiceBus\Handler\Mapping\MapByNamingConvention\MethodName\MethodNameInflectorInterface;
use ReactServiceBus\ServiceBus\Handler\Mapping\MethodToCall;

final class MapByNamingConvention implements CommandToHandlerMappingInterface
{
    public function __construct(
        private ClassNameInflectorInterface $classNameInflector,
        private MethodNameInflectorInterface $methodNameInflector,
    ) {
    }

    /**
     * @throws MethodDoesNotExistException
     */
    public function findHandlerForCommand(string $commandFQCN): MethodToCall
    {
        return new MethodToCall(
            $this->classNameInflector->getClassName($commandFQCN),
            $this->methodNameInflector->getMethodName($commandFQCN),
        );
    }
}
