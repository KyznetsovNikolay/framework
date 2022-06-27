<?php

declare(strict_types=1);

namespace App\Controller;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class IndexAction
{
    public function __invoke(ServerRequestInterface $request): Response
    {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new HtmlResponse('Hello, ' . $name . '!');
    }
}
