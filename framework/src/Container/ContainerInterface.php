<?php

namespace Framework\Container;

use Psr\Container\ContainerInterface as PsrContainerInterface;

interface ContainerInterface extends PsrContainerInterface
{
    public function bind(string $abstract, $concrete, bool $shared = false): void;

    public function singleton(string $abstract, $concrete): void;

    public function has(string $abstract): bool;
}
