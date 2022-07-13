<?php

use Framework\Console\Command\CacheClearCommand;
use Framework\Factory\Command\CacheClearCommandFactory;

return [
    'dependencies' => [
        'factories' => [
            CacheClearCommand::class => CacheClearCommandFactory::class
        ],
    ],
    'console' => [
        'cachePaths' => [
            'twig' => 'var/cache/twig',
        ],
    ],
];

