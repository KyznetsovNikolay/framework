<?php

declare(strict_types=1);

namespace Framework\Template\Extension;

class FuncExtension
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var callable
     */
    public $callback;

    /**
     * @var bool
     */
    public bool $needRenderer;

    public function __construct(string $name, callable $callback, bool $needRenderer = false)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->needRenderer = $needRenderer;
    }
}
