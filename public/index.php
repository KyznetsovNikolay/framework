<?php

use App\Controller\AboutAction;
use App\Controller\Blog\IndexAction;
use App\Controller\Blog\ShowAction;
use App\Controller\CabinetAction;
use App\Controller\IndexAction as HomeAction;
use Aura\Router\RouterContainer;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Resolver;
use Framework\Http\Router\Handler\NotFound;
use Framework\Middleware\Decorator\Auth;
use Framework\Middleware\Decorator\Profiler;
use Framework\Middleware\Pipeline\Pipeline;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Psr\Http\Message\ServerRequestInterface;

chdir(dirname(__DIR__));
require_once  'vendor/autoload.php';

$params = [
    'users' => [
        'user' => 'password'
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
$pipeline = new Pipeline();

$pipeline->pipe($resolver->resolve(Profiler::class));

try {

    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $handlers = $result->getHandler();
    foreach (is_array($handlers) ? $handlers : [$handlers] as $handler) {
        $pipeline->pipe($resolver->resolve($handler));
    }

} catch (Exception $e) {}

$response = $pipeline($request, new NotFound());

$response = $response->withHeader('X-Developer', 'Kyznetsov');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);


