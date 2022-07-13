<?php

use Framework\Factory\Db\PdoFactory;

return [
    'dependencies' => [
        'factories' => [
            PDO::class => PDOFactory::class,
        ]
    ],
    'pdo' => [
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
    ]
];

