<?php

declare(strict_types=1);

namespace Framework\Http\Router;

class Resolver
{
    public function resolver($handler): callable
    {
        return \is_string($handler) ? new $handler : $handler;
    }
}
