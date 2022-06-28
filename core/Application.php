<?php

declare(strict_types=1);

namespace Framework;

use Framework\Http\Resolver;
use Framework\Middleware\Pipeline\Pipeline;

class Application extends Pipeline
{
    /**
     * @var Resolver
     */
    private $resolver;

    public function __construct(Resolver $resolver)
    {
        parent::__construct();
        $this->resolver = $resolver;
    }

    public function pipe($middleware): void
    {
        parent::pipe($this->resolver->resolve($middleware));
    }
}
