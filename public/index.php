<?php

use App\Controller\AboutAction;
use App\Controller\BlogAction;
use App\Controller\BlogShowAction;
use App\Controller\IndexAction;
use Aura\Router\RouterContainer;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Resolver;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

chdir(dirname(__DIR__));
require_once  'vendor/autoload.php';

### Initialization

$aura = new RouterContainer();
$routes = $aura->getMap();

$routes->get('home', '/', IndexAction::class);
$routes->get('about', '/about', AboutAction::class);
$routes->get('blog', '/blog', BlogAction::class);
$routes->get('blog_show', '/blog/{id}', BlogShowAction::class)->tokens(['id' => '\d+']);

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


