<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Handler\Mapping\MapByNamingConvention\MethodName;

/**
 * Assumes the method is handle + the last portion of the class name.
 *
 * Examples:
 *  - \MyGlobalCommand              => $handler->handleMyGlobalCommand()
 *  - \My\App\TaskCompletedCommand  => $handler->handleTaskCompletedCommand()
 */
final class HandleLastPartOfClassName implements MethodNameInflectorInterface
{
    private LastPartOfClassName $lastPartOfClassName;

    public function __construct()
    {
        $this->lastPartOfClassName = new LastPartOfClassName();
    }

    public function getMethodName(string $commandClassName): string
    {
        $commandName = $this->lastPartOfClassName->getMethodName($commandClassName);

        return 'handle'.ucfirst($commandName);
    }
}
