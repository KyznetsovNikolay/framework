<?php

declare(strict_types=1);

namespace Tests\Core\Middleware\data;

use Laminas\Diactoros\Response\EmptyResponse;
use Psr\Http\Message\ServerRequestInterface;

class NotFoundMiddleware
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new EmptyResponse(404);
    }
}
