<?php

declare(strict_types=1);

namespace App\Controller\Blog;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

class ShowAction
{
    public function __invoke(ServerRequestInterface $request, callable $next): Response
    {
        $id = $request->getAttribute('id');
        if ($id > 2) {
            return $next($request);
        }

        return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
    }
}
