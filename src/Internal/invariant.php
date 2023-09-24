<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Internal;

/**
 * @template T of \Throwable
 *
 * @param \Closure(): T $thrower
 *
 * @phpstan-assert true $fact
 *
 * @pure
 *
 * @throws T
 *
 * @internal
 */
function invariant(bool $fact, \Closure $thrower): void
{
    if (!$fact) {
        throw $thrower();
    }
}
