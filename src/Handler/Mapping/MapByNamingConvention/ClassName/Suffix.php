<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Handler\Mapping\MapByNamingConvention\ClassName;

use ReactServiceBus\ServiceBus\Handler\Mapping\MapByNamingConvention\Exception\ClassDoesNotExistException;

use function ReactServiceBus\ServiceBus\Internal\invariant;

final class Suffix implements ClassNameInflectorInterface
{
    public function __construct(
        private string $suffix
    ) {
    }

    /**
     * @param class-string $commandClassName
     *
     * @throws ClassDoesNotExistException
     */
    public function getClassName(string $commandClassName): string
    {
        $handlerClassName = $commandClassName.$this->suffix;

        /** @throws ClassDoesNotExistException */
        invariant(class_exists($handlerClassName), static fn () => ClassDoesNotExistException::on($handlerClassName));

        return $handlerClassName;
    }
}
