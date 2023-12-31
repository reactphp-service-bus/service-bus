<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__.'/src',
        __DIR__.'/tests',
        __DIR__.'/examples',
    ]);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => true,
        '@PSR2' => true,
        '@DoctrineAnnotation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'php_unit_method_casing' => ['case' => 'snake_case'],
        'phpdoc_to_comment' => [
            'ignored_tags' => [
                'var',
                'throws',
            ],
        ],
        'static_lambda' => true,
    ])
    ->setFinder($finder)
;
