<?php

declare(strict_types=1);

namespace ReactServiceBus\ServiceBus\Tests;

use PHPUnit\Framework;

#[Framework\Attributes\CoversNothing]
final class ExamplesTest extends Framework\TestCase
{
    /**
     * @param string[] $expect
     */
    #[Framework\Attributes\DataProvider('exampleFiles')]
    public function test_example(string $file, array $expect): void
    {
        // executes the example script using the php binary
        exec(
            implode(
                ' ',
                [
                    PHP_BINARY,
                    '-f',
                    escapeshellarg(__DIR__."/../examples/{$file}"),
                ]
            ),
            $output,
            $exitCode
        );

        self::assertSame(0, $exitCode);
        self::assertSame($expect, $output);
    }

    /**
     * @return array<int, array<int, array<int, string>|string>>
     */
    public static function exampleFiles(): array
    {
        return [
            [
                '1-beginner-standard-usage.php',
                ['User alice@example.com was registered!'],
            ],
//            [
//                '2-intermediate-create-middleware.php',
//                [
//                    'LOG: Starting RegisterUser',
//                    'User alice@example.com was registered!',
//                    'LOG: RegisterUser finished without errors',
//                ],
//            ],
//            [
//                '3-intermediate-custom-naming-conventions.php',
//                ['See, Tactician now calls the handle method we prefer!'],
//            ],
//            [
//                '4-conditional-handlers.php',
//                [
//                    'Dispatched MyExternalCommand!',
//                    'User alice@example.com was registered!',
//                ],
//            ],
        ];
    }
}
