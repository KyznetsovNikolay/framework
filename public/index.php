<?php

use App\Controller\AboutAction;
use App\Controller\Blog\IndexAction;
use App\Controller\Blog\ShowAction;
use App\Controller\CabinetAction;
use App\Controller\IndexAction as HomeAction;
use Aura\Router\RouterContainer;
use Framework\Container\Container;
use Framework\Middleware\Decorator\Dispatch as DispatchMiddleware;
use Framework\Middleware\Decorator\Error as ErrorMiddleware;
use Framework\Application;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Resolver;
use Framework\Http\Router\Handler\NotFound;
use Framework\Middleware\Decorator\Auth as AuthMiddleware;
use Framework\Middleware\Decorator\Credential as CredentialMiddleware;
use Framework\Middleware\Decorator\Profiler as ProfilerMiddleware;
use Framework\Middleware\Decorator\Route as RouteMiddleware;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require_once  'vendor/autoload.php';

### Initialization

$container = new Container();
$container->set('config', [
    'users' => [
        'user' => 'password'
    ],
    'headers' => [
        'tata' => 'hello',
        'some' => 'new',
        'X-Developer' => 'Kyznetsov'
    ],
    'debug' => true
]);

$aura = new RouterContainer();
$routes = $aura->getMap();

$routes->get('home', '/', HomeAction::class);
$routes->get('about', '/about', AboutAction::class);
$routes->get('blog', '/blog', IndexAction::class);
$routes->get('cabinet', '/cabinet', [
    new AuthMiddleware($container->get('config')['users']),
    CabinetAction::class,
]);
$routes->get('blog_show', '/blog/{id}', ShowAction::class)->tokens(['id' => '\d+']);

### Running

$router = new AuraRouterAdapter($aura);
$resolver = new Resolver();
$request = ServerRequestFactory::fromGlobals();
$app = new Application($request, $resolver, new NotFound());

$app->pipe(new ErrorMiddleware($container->get('config')['debug']));
$app->pipe(ProfilerMiddleware::class);
$app->pipe(new CredentialMiddleware($container->get('config')['headers']));
$app->pipe(new RouteMiddleware($router));
$app->pipe(new DispatchMiddleware($resolver));

$response = $app->run(new Response());

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);


