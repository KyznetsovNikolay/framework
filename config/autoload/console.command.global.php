<?php

use Framework\Console\Command\CacheClearCommand;
use Framework\Factory\Command\ApplicationConsoleFactory;
use Framework\Factory\Command\CacheClearCommandFactory;
use Symfony\Component\Console\Application;

return [
    'dependencies' => [
        'factories' => [
            Application::class => ApplicationConsoleFactory::class,
            CacheClearCommand::class => CacheClearCommandFactory::class
        ],
    ],
    'console' => [
        'cachePaths' => [
            'twig' => 'var/cache/twig',
        ],
        'commands' => [
            CacheClearCommand::class
        ],
    ],
];

