<?php

declare(strict_types=1);

namespace Devnix\React\ServiceBus;

use React\Promise\PromiseInterface;

interface ServiceBusInterface
{
    /**
     * @return PromiseInterface<mixed>
     */
    public function dispatch(object $command): PromiseInterface;
}
