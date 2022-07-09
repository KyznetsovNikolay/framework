<?php

declare(strict_types=1);

namespace Framework\Template\Extension;

abstract class Extension
{
    public function getFunctions(): array
    {
        return [];
    }
}
