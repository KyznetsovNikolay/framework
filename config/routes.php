<?php

use Framework\Application;
use Framework\Container\Container;
use App\Controller\AboutAction;
use App\Controller\Blog\IndexAction;
use App\Controller\Blog\ShowAction;
use App\Controller\CabinetAction;
use App\Controller\IndexAction as HomeAction;

/**
 * @var Application $app
 * @var Container $container
 */
$app->get('home', '/', HomeAction::class);
$app->get('about', '/about', AboutAction::class);
$app->get('blog', '/blog', IndexAction::class);
$app->get('blog_page', '/blog/page/{page}', IndexAction::class, ['tokens' => ['page' => '\d+']]);
$app->get('cabinet', '/cabinet', CabinetAction::class);
$app->get('blog_show', '/blog/{id}', ShowAction::class, ['tokens' => ['id' => '\d+']]);

