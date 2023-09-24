<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Handler\Mapping\MapByNamingConvention\Exception;

use ReactServiceBus\ServiceBus\ExceptionInterface;

final class MethodDoesNotExistException extends \BadMethodCallException implements ExceptionInterface
{
    private function __construct(
        string $message,
        protected string $className,
        protected string $methodName
    ) {
        parent::__construct($message);
    }

    public static function on(string $className, string $methodName): self
    {
        return new self(
            'The handler method '.$className.'::'.$methodName.' does not exist. Please check your ReactServiceBus '.
            'mapping configuration or check verify that '.$methodName.' is actually declared in . '.$className,
            $className,
            $methodName
        );
    }

    public function getClassName(): string
    {
        return $this->className;
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }
}
