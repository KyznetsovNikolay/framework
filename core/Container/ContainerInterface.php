<?php

declare(strict_types=1);

namespace Framework\Container;

use Framework\Container\Exception\NotFoundExceptionInterface;

interface ContainerInterface
{
    /**
     * @throws NotFoundExceptionInterface
     */
    public function get($id);

    /**
     * @param $id
     * @return bool
     */
    public function has($id): bool;
}
