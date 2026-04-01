<?php

namespace Framework\Container;

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Framework\Container\Exceptions\ContainerException;
use Framework\Container\Exceptions\NotFoundException;

class Container implements ContainerInterface
{
    protected $instances = [];

    protected $bindings = [];

    public function has($id): bool
    {
        return isset($this->bindings[$id]) || isset($this->instances[$id]);
    }

    public function bind(string $abstract, $concrete, bool $shared = false): void
    {
        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'shared' => $shared
        ];

        if ($shared) {
            $this->instances[$abstract] = null;
        }
    }

    public function singleton(string $abstract, $concrete): void
    {
        $this->bind($abstract, $concrete, true);
    }

    public function get($id)
    {
        if (isset($this->instances[$id])) {
            return $this->instances[$id];
        }

        if (!isset($this->bindings[$id])) {
            throw new NotFoundException("No entry or class found for '{$id}'");
        }

        $concrete = $this->bindings[$id]['concrete'];
        $shared = $this->bindings[$id]['shared'];

        if ($concrete instanceof \Closure) {
            $object = $concrete($this);
        } elseif (is_string($concrete)) {
            $object = $this->resolveClass($concrete);
        } else {
            throw new ContainerException("Invalid concrete implementation for '{$id}'");
        }

        if ($shared) {
            $this->instances[$id] = $object;
        }

        return $object;
    }

    protected function resolveClass(string $class)
    {
        try {
            $reflector = new ReflectionClass($class);

            if (!$reflector->isInstantiable()) {
                throw new ContainerException("Class '{$class}' is not instantiable");
            }

            $constructor = $reflector->getConstructor();

            if (is_null($constructor)) {
                return $reflector->newInstance();
            }

            $dependencies = $this->resolveDependencies($constructor->getParameters());
            return $reflector->newInstanceArgs($dependencies);

        } catch (ReflectionException $e) {
            throw new ContainerException("Failed to resolve class '{$class}': " . $e->getMessage(), 0, $e);
        }
    }

    protected function resolveDependencies(array $parameters): array
    {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType();

            if ($dependency === null) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new ContainerException("Cannot resolve non-class parameter '{$parameter->getName()}'");
                }
            } else {
                $dependencyName = $dependency->getName();
                $dependencies[] = $this->get($dependencyName);
            }
        }

        return $dependencies;
    }
}