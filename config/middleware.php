<?php

use Framework\Application;
use Framework\Middleware\Decorator\Auth;
use Framework\Middleware\Decorator\Dispatch;
use Framework\Middleware\Decorator\Credential;
use Framework\Middleware\Decorator\Profiler;
use Framework\Middleware\Decorator\ResponseLogger;
use Framework\Middleware\Decorator\Route;
use Framework\Middleware\Decorator\Error;

/**
 * @var Application $app
 */
$app->pipe(Error::class);
$app->pipe(ResponseLogger::class);
$app->pipe(Profiler::class);
$app->pipe(Credential::class);
$app->pipe('cabinet', Auth::class);
$app->pipe(Route::class);
$app->pipe(Dispatch::class);
