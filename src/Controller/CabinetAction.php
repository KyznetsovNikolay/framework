<?php

declare(strict_types=1);

namespace App\Controller;

use Framework\Middleware\Decorator\Auth;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;

class CabinetAction
{
    public function __invoke(ServerRequestInterface $request)
    {
        $username = $request->getAttribute(Auth::USER);
        return new HtmlResponse('I am logged in as ' . $username);
    }
}
