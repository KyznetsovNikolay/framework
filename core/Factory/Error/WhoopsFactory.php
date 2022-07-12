<?php

declare(strict_types=1);

namespace Framework\Factory\Error;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsFactory
{
    public function __invoke()
    {
        $whoops = new Run();
        $whoops->writeToOutput(false);
        $whoops->allowQuit(false);
        $whoops->pushHandler(new PrettyPageHandler());
        $whoops->register();
        return $whoops;
    }
}
