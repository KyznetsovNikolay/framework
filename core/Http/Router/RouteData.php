<?php

declare(strict_types=1);

namespace Framework\Http\Router;

class RouteData
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $path;

    /**
     * @var mixed
     */
    public $handler;

    /**
     * @var array
     */
    public $methods;

    /**
     * @var array
     */
    public $options;

    public function __construct($name, $path, $handler, array $methods, array $options)
    {
        $this->name = $name;
        $this->path = $path;
        $this->handler = $handler;
        $this->methods = array_map('mb_strtoupper', $methods);
        $this->options = $options;
    }
}
