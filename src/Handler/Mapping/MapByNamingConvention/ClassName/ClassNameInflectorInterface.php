<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Handler\Mapping\MapByNamingConvention\ClassName;

/**
 * Extract the name from a command so that the name can be determined
 * by the context better than simply the class name.
 */
interface ClassNameInflectorInterface
{
    /**
     * Deduce the FQCN of the Handler based on the command FQCN.
     *
     * @return class-string
     */
    public function getClassName(string $commandClassName): string;
}
