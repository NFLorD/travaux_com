<?php

namespace App\Math;

abstract class Object2D
{
    public array $coordinates = [];

    public function __construct(
        public string $name,
        Coordinate $x,
        Coordinate $y
    ) {
        $this->coordinates[$x->name] = $x->value;
        $this->coordinates[$y->name] = $y->value;
    }

    public function __get(string $name): int
    {
        return $this->coordinates[$name];
    }

    public function __set(string $name, int $coordinate): void
    {
        $this->coordinates[$name] = $coordinate;
    }
}