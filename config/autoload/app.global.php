<?php

declare(strict_types=1);

use Framework\Application;
use Framework\Factory\ApplicationFactory;
use Framework\Factory\CredentialFactory;
use Framework\Factory\ErrorHandlerFactory;
use Framework\Factory\MonologLoggerFactory;
use Framework\Factory\ResolverFactory;
use Framework\Factory\RouterFactory;
use Framework\Http\Resolver;
use Framework\Http\Router\RouterInterface;
use Framework\Middleware\Decorator\Credential;
use Framework\Middleware\Decorator\Error;
use Framework\Middleware\Decorator\Profiler;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Psr\Log\LoggerInterface;

return [
    'dependencies' => [
        'invokables' => [
            Profiler::class,
        ],
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            Application::class => ApplicationFactory::class,
            RouterInterface::class => RouterFactory::class,
            Resolver::class => ResolverFactory::class,
            Error::class => ErrorHandlerFactory::class,
            Credential::class => CredentialFactory::class,
            LoggerInterface::class => MonologLoggerFactory::class
        ],
    ],
];
