<?php

use Framework\Application;
use Framework\Container\Container;
use App\Controller\AboutAction;
use App\Controller\Blog\IndexAction;
use App\Controller\Blog\ShowAction;
use App\Controller\CabinetAction;
use App\Controller\IndexAction as HomeAction;
use Framework\Middleware\Decorator\Auth;

/**
 * @var Application $app
 * @var Container $container
 */
$app->get('home', '/', HomeAction::class);
$app->get('about', '/about', AboutAction::class);
$app->get('blog', '/blog', IndexAction::class);
$app->get('cabinet', '/cabinet', [
    $container->get(Auth::class),
    CabinetAction::class,
]);
$app->get('blog_show', '/blog/{id}', ShowAction::class, ['tokens' => ['id' => '\d+']]);

