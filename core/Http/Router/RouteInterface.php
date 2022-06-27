<?php

declare(strict_types=1);

namespace Framework\Http\Router;

use Psr\Http\Message\ServerRequestInterface;

interface RouteInterface
{
    public function match(ServerRequestInterface $request): ?Result;

    public function generate($name, array $params = []): ?string;
}
