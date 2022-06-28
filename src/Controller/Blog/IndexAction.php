<?php

declare(strict_types=1);

namespace App\Controller;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class BlogAction
{
    public function __invoke(ServerRequestInterface $request): Response
    {
        return new JsonResponse([
            ['id' => 1, 'title' => 'First post'],
            ['id' => 2, 'title' => 'Second post'],
        ]);
    }
}
