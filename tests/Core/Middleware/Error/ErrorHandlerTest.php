<?php

declare(strict_types=1);

namespace Tests\Core\Middleware\Error;

use Framework\Middleware\Decorator\Error;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Tests\Core\Middleware\Error\data\CorrectAction;
use Tests\Core\Middleware\Error\data\DummyGenerator;
use Tests\Core\Middleware\Error\data\ErrorAction;

class ErrorHandlerTest extends TestCase
{
    public function testNone(): void
    {
        $handler = new Error(new DummyGenerator());
        $response = $handler->process(new ServerRequest(), new CorrectAction());

        self::assertEquals('Content', $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testException(): void
    {
        $handler = new Error(new DummyGenerator());
        $response = $handler->process(new ServerRequest(), new ErrorAction());

        self::assertEquals('Runtime Error', $response->getBody()->getContents());
        self::assertEquals(500, $response->getStatusCode());
    }
}
