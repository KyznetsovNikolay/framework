<?php

declare(strict_types=1);

namespace App\Controller;

use Framework\Base\Controller\BaseController;
use Framework\Middleware\Decorator\Auth;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CabinetAction extends BaseController
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $username = $request->getAttribute(Auth::USER);
        return new HtmlResponse($this->render('main/cabinet', [
            'username' => $username,
        ]));
    }
}
