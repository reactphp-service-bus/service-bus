<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Handler\Mapping\MapByNamingConvention\MethodName;

/**
 * Deduce the method name to call on the command handler based on the command
 * and handler classes.
 */
interface MethodNameInflectorInterface
{
    /**
     * Return the method name to call on the command handler.
     */
    public function getMethodName(string $commandClassName): string;
}
