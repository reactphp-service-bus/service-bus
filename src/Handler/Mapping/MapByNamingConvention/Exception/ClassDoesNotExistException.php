<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Handler\Mapping\MapByNamingConvention\Exception;

use ReactServiceBus\ServiceBus\ExceptionInterface;

final class ClassDoesNotExistException extends \BadMethodCallException implements ExceptionInterface
{
    private function __construct(
        string $message,
        protected string $className,
    ) {
        parent::__construct($message);
    }

    public static function on(string $className): self
    {
        return new self(
            'The handler class '.$className.' does not exist.',
            $className,
        );
    }

    public function getClassName(): string
    {
        return $this->className;
    }
}
