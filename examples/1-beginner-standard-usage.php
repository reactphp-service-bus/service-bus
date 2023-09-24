<?php

require __DIR__.'/../vendor/autoload.php';

use League\Container;
use React\Promise;
use ReactServiceBus\ServiceBus;

final class RegisterUser
{
    public function __construct(
        public readonly string $emailAddress,
        public readonly string $password,
    ) {
    }
}

final class RegisterUserHandler
{
    /**
     * @return Promise\PromiseInterface<null>
     */
    public function handleRegisterUser(RegisterUser $command): Promise\PromiseInterface
    {
        echo "User {$command->emailAddress} was registered!\n";

        return Promise\resolve(null);
    }
}

$container = new Container\Container();
$container->add(RegisterUserHandler::class);

$handlerMiddleware = new ReactServiceBus\ServiceBus\Handler\CommandHandlerMiddleware(
    $container,
    new ServiceBus\Handler\Mapping\MapByNamingConvention\MapByNamingConvention(
        new ServiceBus\Handler\Mapping\MapByNamingConvention\ClassName\Suffix('Handler'),
        new ServiceBus\Handler\Mapping\MapByNamingConvention\MethodName\HandleLastPartOfClassName()
    )
);

$commandBus = new ReactServiceBus\ServiceBus\ServiceBus($handlerMiddleware);

$commandBus->dispatch(
    new RegisterUser(
        emailAddress: 'alice@example.com',
        password: 'secret',
    )
);
