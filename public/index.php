<?php

use App\Controller\AboutAction;
use App\Controller\Blog\IndexAction;
use App\Controller\Blog\ShowAction;
use App\Controller\CabinetAction;
use App\Controller\IndexAction as HomeAction;
use Aura\Router\RouterContainer;
use Framework\Application;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Resolver;
use Framework\Http\Router\Handler\NotFound;
use Framework\Middleware\Decorator\Auth;
use Framework\Middleware\Decorator\Credential;
use Framework\Middleware\Decorator\Profiler;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require_once  'vendor/autoload.php';

$params = [
    'users' => [
        'user' => 'password'
    ],
    'headers' => [
        'tata' => 'hello',
        'some' => 'new',
        'X-Developer' => 'Kyznetsov'
    ],
];
### Initialization

$aura = new RouterContainer();
$routes = $aura->getMap();

$auth = new Auth($params['users']);

$routes->get('home', '/', HomeAction::class);
$routes->get('about', '/about', AboutAction::class);
$routes->get('blog', '/blog', IndexAction::class);
$routes->get('cabinet', '/cabinet', [
    new Auth($params['users']),
    CabinetAction::class,
]);
$routes->get('blog_show', '/blog/{id}', ShowAction::class)->tokens(['id' => '\d+']);

### Running

$router = new AuraRouterAdapter($aura);
$resolver = new Resolver();
$request = ServerRequestFactory::fromGlobals();
$app = new Application($resolver, new NotFound());

$app->pipe($resolver->resolve(Profiler::class));
$app->pipe($resolver->resolve(new Credential($params['headers'])));

try {

    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $app->pipe($resolver->resolve($result->getHandler()));

} catch (Exception $e) {}

$response = $app->run($request);

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);


