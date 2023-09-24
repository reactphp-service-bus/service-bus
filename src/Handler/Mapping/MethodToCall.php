<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Handler\Mapping;

use ReactServiceBus\ServiceBus\Handler\Mapping\MapByNamingConvention\Exception\MethodDoesNotExistException;

use function ReactServiceBus\ServiceBus\Internal\invariant;

final class MethodToCall
{
    /**
     * @param class-string $className
     *
     * @throws MethodDoesNotExistException
     */
    public function __construct(
        public readonly string $className,
        public readonly string $methodName,
    ) {
        /** @throws MethodDoesNotExistException */
        invariant(
            method_exists($className, $methodName),
            static fn () => MethodDoesNotExistException::on($className, $className)
        );
    }
}
