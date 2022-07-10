<?php

declare(strict_types=1);

namespace Core\Middleware;

use Framework\Http\Resolver;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Tests\Core\Container\DummyContainer;
use Tests\Core\Middleware\data\CallableMiddleware;
use Tests\Core\Middleware\data\DoublePassMiddleware;
use Tests\Core\Middleware\data\DummyMiddleware;
use Tests\Core\Middleware\data\NotFoundMiddleware;
use Tests\Core\Middleware\data\Psr15Middleware;

class ResolverTest extends TestCase
{
    /**
     * @dataProvider getValidHandlers
     * @param $handler
     */
    public function testDirect($handler): void
    {
        $resolver = new Resolver(new DummyContainer(), new Response());
        $middleware = $resolver->resolve($handler);

        $response = $middleware->process(
            (new ServerRequest())->withAttribute('attribute', $value = 'value'),
            new NotFoundMiddleware()
        );

        self::assertEquals([$value], $response->getHeader('X-Header'));
    }

    /**
     * @dataProvider getValidHandlers
     * @param $handler
     */
    public function testNext($handler): void
    {
        $resolver = new Resolver(new DummyContainer(), new Response());
        $middleware = $resolver->resolve($handler);

        $response = $middleware->process(
            (new ServerRequest())->withAttribute('next', true),
            new NotFoundMiddleware()
        );

        self::assertEquals(404, $response->getStatusCode());
    }

    public function getValidHandlers(): array
    {
        return [
            'Callable Callback' => [function (ServerRequestInterface $request, callable $next) {
                if ($request->getAttribute('next')) {
                    return $next($request);
                }
                return (new HtmlResponse(''))
                    ->withHeader('X-Header', $request->getAttribute('attribute'));
            }],
            'Callable Class' => [CallableMiddleware::class],
            'Callable Object' => [new CallableMiddleware()],
            'DoublePass Callback' => [function (ServerRequestInterface $request, ResponseInterface $response, callable $next) {
                if ($request->getAttribute('next')) {
                    return $next($request, $response);
                }
                return $response
                    ->withHeader('X-Header', $request->getAttribute('attribute'));
            }],
            'DoublePass Class' => [DoublePassMiddleware::class],
            'DoublePass Object' => [new DoublePassMiddleware()],
            'Interop Class' => [Psr15Middleware::class],
            'Interop Object' => [new Psr15Middleware()],
        ];
    }

    public function testArray(): void
    {
        $resolver = new Resolver(new DummyContainer(), new Response());

        $middleware = $resolver->resolve([
            new DummyMiddleware(),
            new CallableMiddleware()
        ]);

        $response = $middleware->process(
            (new ServerRequest())->withAttribute('attribute', $value = 'value'),
            new NotFoundMiddleware()
        );

        self::assertEquals(['dummy'], $response->getHeader('X-Dummy'));
        self::assertEquals([$value], $response->getHeader('X-Header'));
    }
}
