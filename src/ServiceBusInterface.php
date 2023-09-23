<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus;

use React\Promise;

interface ServiceBusInterface
{
    /**
     * @return Promise\PromiseInterface<mixed>
     */
    public function dispatch(object $command): Promise\PromiseInterface;
}
