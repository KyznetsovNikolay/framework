<?php

declare(strict_types=1);

namespace App\Controller;

use Framework\Base\Controller\BaseController;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AboutAction extends BaseController
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse($this->render('main/about'));
    }
}
