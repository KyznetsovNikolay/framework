<?php

declare(strict_types=1);

namespace Framework\Http\Router\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class NotFound
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new HtmlResponse('Undefined page', 404);
    }
}
