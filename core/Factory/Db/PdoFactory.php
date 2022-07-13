<?php

declare(strict_types=1);

namespace Framework\Factory\Db;

use Psr\Container\ContainerInterface;

class PdoFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')['pdo'];
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s',
            $config['host'],
            $config['port'],
            $config['db_name']
        );

        return new \PDO(
            $dsn,
            $config['user'],
            $config['pass'],
            $config['options']
        );
    }
}
