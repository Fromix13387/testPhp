<?php

namespace app\core;

use RuntimeException;

class Container
{
    private array $bindings;
    private array $instances = [];
    private array $resolved = [];
    public function __construct(array $config)
    {
        foreach ($config as $name => $binding) {
            $this->bindings[$name] = $binding;

            if (is_array($binding) && isset($binding['class'])) {
                $this->bindings[$binding['class']] = $binding;
            }
        }
    }

    public function get(string $name) {
        if(array_key_exists($name, $this->instances)) {
            return $this->instances[$name];
        }

        if (!array_key_exists($name, $this->bindings)) {
            throw new RuntimeException("[$name] не найден");
        }

        $binding = $this->bindings[$name];
        if(is_array($binding) && isset($binding['class'])) {
            $className = $binding['class'];
            unset($binding['class']);
            $this->instances[$name] = new $className($binding);
            return $this->instances[$name];
        }
        return $binding;
    }
    public function bind(string $name, mixed $value): void
    {
        $this->bindings[$name] = $value;
        unset($this->instances[$name]);
    }

    public function make(string $class): mixed
    {
        if (array_key_exists($class, $this->bindings)) {
            return $this->get($class);
        }

        if(isset($this->resolved[$class])) {
            throw new RuntimeException( "Цикличная зависимость: {$class}" );
        }

        $this->resolved[$class] = true;

        try {
            $reflection = new \ReflectionClass($class);

            $constructor = $reflection->getConstructor();

            if ($constructor === null) {
                return new $class();
            }

            $dependencies = [];
            foreach ($constructor->getParameters() as $parameter) {
                $type = $parameter->getType();

                if (!$type instanceof \ReflectionNamedType || $type->isBuiltin()) {
                    throw new RuntimeException(
                        "Нельзя создать {$parameter->getName()} in {$class}"
                    );
                }

                $dependencies[] = $this->make($type->getName());
            }

            return $reflection->newInstanceArgs($dependencies);

        } finally {
            unset($this->resolved[$class]);
        }
    }
}