<?php

declare(strict_types=1);

namespace Framework\Factory;

use Aura\Router\RouterContainer;
use Framework\Http\Router\AuraRouterAdapter;

class RouterFactory
{
    /**
     * @return AuraRouterAdapter
     */
    public function __invoke()
    {
        return new AuraRouterAdapter(new RouterContainer());
    }
}
