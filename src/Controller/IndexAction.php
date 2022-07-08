<?php

declare(strict_types=1);

namespace App\Controller;

use Framework\Base\Controller\BaseController;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class IndexAction extends BaseController
{
    public function __invoke(ServerRequestInterface $request): Response
    {
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new HtmlResponse($this->render('main.home', ['name' => $name]));
    }
}
