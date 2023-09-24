<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Handler\Mapping\MapByNamingConvention\MethodName;

/**
 * Assumes the method is only the last portion of the class name.
 *
 * Examples:
 *  - \MyGlobalCommand    => $handler->myGlobalCommand()
 *  - \My\App\CreateUser  => $handler->createUser()
 */
final class LastPartOfClassName implements MethodNameInflectorInterface
{
    public function __construct()
    {
    }

    public function getMethodName(string $commandClassName): string
    {
        $lastNamespaceSeparatorPosition = strrpos($commandClassName, '\\');

        // If class name has a namespace separator, only take last portion
        if (false !== $lastNamespaceSeparatorPosition) {
            $commandClassName = substr($commandClassName, $lastNamespaceSeparatorPosition + 1);
        }

        return strtolower($commandClassName[0]).substr($commandClassName, 1);
    }
}
