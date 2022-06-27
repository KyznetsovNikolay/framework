<?php

declare(strict_types=1);

namespace App\Controller;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class AboutAction
{
    public function __invoke(ServerRequestInterface $request): Response
    {
        return new HtmlResponse('About page.');
    }
}
