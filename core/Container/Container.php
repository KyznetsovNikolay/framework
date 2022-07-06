<?php

declare(strict_types=1);

namespace Framework\Container;

use Framework\Container\Exception\ServiceNotFoundException;

class Container
{
    private $definitions = [];

    private $results = [];

    public function get($id)
    {
        if (array_key_exists($id, $this->results)) {
            return $this->results[$id];
        }

        if (!array_key_exists($id, $this->definitions)) {
            throw new ServiceNotFoundException('Unknown service "' . $id . '"');
        }

        $definition = $this->definitions[$id];

        if ($definition instanceof \Closure) {
            $this->results[$id] = $definition($this);
        } else {
            $this->results[$id] = $definition;
        }

        return $this->results[$id];
    }

    public function set($id, $value): void
    {
        if (array_key_exists($id, $this->results)) {
            unset($this->results[$id]);
        }

        $this->definitions[$id] = $value;
    }
}
