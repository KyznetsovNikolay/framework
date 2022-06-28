<?php

use App\Controller\AboutAction;
use App\Controller\Blog\IndexAction;
use App\Controller\Blog\ShowAction;
use App\Controller\CabinetAction;
use App\Controller\IndexAction as HomeAction;
use Aura\Router\RouterContainer;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Resolver;
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
$routes->get('cabinet', '/cabinet', function(ServerRequestInterface $request) use ($params) {
    $pipeline = new Pipeline();

    $pipeline->pipe(new Profiler());
    $pipeline->pipe(new Auth($params['users']));
    $pipeline->pipe(new CabinetAction());

    return $pipeline($request, function () {
        return new HtmlResponse('Undefined page', 404);
    });
});
$routes->get('blog_show', '/blog/{id}', ShowAction::class)->tokens(['id' => '\d+']);

### Running

$router = new AuraRouterAdapter($aura);
$resolver = new Resolver();
$request = ServerRequestFactory::fromGlobals();

try {

    $result = $router->match($request);
    foreach ($result->getAttributes() as $attribute => $value) {
        $request = $request->withAttribute($attribute, $value);
    }
    $handler = $resolver->resolver($result->getHandler());
    $response = $handler($request);

} catch (Exception $e) {
    return new JsonResponse(['Undefined page'], 404);
}

$response = $response->withHeader('X-Developer', 'Kyznetsov');

### Sending

$emitter = new SapiEmitter();
$emitter->emit($response);


