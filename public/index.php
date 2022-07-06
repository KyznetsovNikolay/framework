<?php

use App\Controller\AboutAction;
use App\Controller\Blog\IndexAction;
use App\Controller\Blog\ShowAction;
use App\Controller\CabinetAction;
use App\Controller\IndexAction as HomeAction;
use Aura\Router\RouterContainer;
use Framework\Container\Container;
use Framework\Http\Router\RouterInterface;
use Framework\Middleware\Decorator\Dispatch;
use Framework\Middleware\Decorator\Error;
use Framework\Application;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Resolver;
use Framework\Http\Router\Handler\NotFound;
use Framework\Middleware\Decorator\Auth;
use Framework\Middleware\Decorator\Credential;
use Framework\Middleware\Decorator\Profiler as ProfilerMiddleware;
use Framework\Middleware\Decorator\Route;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require_once  'vendor/autoload.php';

### Initialization

$container = new Container();
$container->set('config', [
    'users' => [
        'admin' => 'password'
    ],
    'headers' => [
        'tata' => 'hello',
        'some' => 'new',
        'X-Developer' => 'Kyznetsov'
    ],
    'debug' => true
]);

$container->set(Application::class, function (Container $container) {
    $request = ServerRequestFactory::fromGlobals();
    return new Application(
        $request,
        $container->get(Resolver::class),
        $container->get(RouterInterface::class),
        new NotFound()
    );
});

$container->set(Auth::class, function (Container $container) {
    return new Auth($container->get('config')['users']);
});

$container->set(Error::class, function (Container $container) {
    return new Error($container->get('config')['debug']);
});

$container->set(Credential::class, function (Container $container) {
    return new Credential($container->get('config')['headers']);
});

$container->set(Route::class, function (Container $container) {
    return new Route($container->get(RouterInterface::class));
});

$container->set(Dispatch::class, function (Container $container) {
    return new Dispatch($container->get(Resolver::class));
});

$container->set(Resolver::class, function () {
    return new Resolver();
});

$container->set(RouterInterface::class, function () {
    return new AuraRouterAdapter(new RouterContainer());
});

$app = $container->get(Application::class);

$app->pipe($container->get(Error::class));
$app->pipe(ProfilerMiddleware::class);
$app->pipe($container->get(Credential::class));
$app->pipe($container->get(Route::class));
$app->pipe($container->get(Dispatch::class));

$app->get('home', '/', HomeAction::class);
$app->get('about', '/about', AboutAction::class);
$app->get('blog', '/blog', IndexAction::class);
$app->get('cabinet', '/cabinet', [
    $container->get(Auth::class),
    CabinetAction::class,
]);
$app->get('blog_show', '/blog/{id}', ShowAction::class, ['tokens' => ['id' => '\d+']]);


$response = $app->run(new Response());

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);


