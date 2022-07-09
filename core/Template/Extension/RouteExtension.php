<?php

declare(strict_types=1);

namespace Framework\Template\Extension;

use Framework\Http\Router\RouterInterface;

class RouteExtension extends Extension
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return array[]
     */
    public function getFunctions(): array
    {
        return [
            new FuncExtension('path', [$this, 'generatePath']),
        ];
    }

    public function generatePath($name, array $params = []): string
    {
        return $this->router->generate($name, $params);
    }
}
