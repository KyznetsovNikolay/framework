<?php

use Framework\Application;
use Framework\Container\Container;
use Framework\Middleware\Decorator\Dispatch;
use Framework\Middleware\Decorator\Credential;
use Framework\Middleware\Decorator\Profiler;
use Framework\Middleware\Decorator\Route;
use Framework\Middleware\Decorator\Error;

/**
 * @var Application $app
 * @var Container $container
 */
$app->pipe($container->get(Error::class));
$app->pipe(Profiler::class);
$app->pipe($container->get(Credential::class));
$app->pipe($container->get(Route::class));
$app->pipe($container->get(Dispatch::class));
