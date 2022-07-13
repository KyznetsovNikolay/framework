<?php

use Framework\Console\Application;
use Framework\Console\Command\CacheClearCommand;
use Framework\Factory\Command\ApplicationConsoleFactory;
use Framework\Factory\Command\CacheClearCommandFactory;

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

