<?php

declare(strict_types=1);

namespace Framework\Container;

use Framework\Container\Exception\ServiceNotFoundException;

class Container
{
    /**
     * @var array
     */
    private $definitions = [];

    /**
     * @var array
     */
    private $results = [];

    /**
     * @var array
     */
    private array $arguments = [];

    /**
     * @throws \ReflectionException
     */
    public function get($id)
    {
        if (array_key_exists($id, $this->results)) {
            return $this->results[$id];
        }

        if (!array_key_exists($id, $this->definitions)) {
            if (class_exists($id)) {
                $reflection = new \ReflectionClass($id);
                $arguments = [];
                if (($constructor = $reflection->getConstructor()) !== null) {

                    foreach ($constructor->getParameters() as $parameter) {
                        if ($paramClass = $parameter->getClass()) {
                            $arguments[] = $this->get($paramClass->getName());
                        } else {
                            if (!$parameter->isDefaultValueAvailable()) {
                                $defaultParameters = $this->arguments[$id];
                                if ($argument = $defaultParameters[$parameter->getName()]) {
                                    return $argument;
                                } else {
                                    throw new ServiceNotFoundException('Unable to resolve "' . $parameter->getName() . '"" in service "' . $id . '"');
                                }
                            } else {
                                $arguments[] = $parameter->getDefaultValue();
                            }
                        }
                    }
                }

                $this->results[$id] = $reflection->newInstanceArgs($arguments);
                return $this->results[$id];
            }
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

    public function has($id): bool
    {
        return array_key_exists($id, $this->definitions) || class_exists($id);
    }

    public function setDefaultArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @param string $id
     * @param string $paramName
     * @return mixed
     */
    private function getArgument(string $id, string $paramName)
    {
        $defaultParameters = $this->arguments[$id];
        if ($argument = $defaultParameters[$paramName]) {
            return $argument;
        } else {
            throw new ServiceNotFoundException('Unable to resolve "' . $paramName . '"" in service "' . $id . '"');
        }
    }
}
