<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Handler\Mapping;

interface CommandToHandlerMappingInterface
{
    public function findHandlerForCommand(string $commandFQCN): MethodToCall;
}
