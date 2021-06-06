<?php

namespace App\Math;

class Grid
{
    /** @var array<Edge> $edges */
    protected array $edges;

    protected array $objects = [];

    /** @param array<Edge> $edges */
    public function __construct(array $edges) {
        foreach ($edges as $edge) {
            $this->edges[$edge->direction->name] = $edge;
        }
    }

    public function __get(string $name): Edge
    {
        return $this->edges[$name];
    }

    public function add(Object2D $object)
    {
        $this->objects[$object->x] ??= [];
        $this->objects[$object->x][$object->y] ??= [];
        
        $this->objects[$object->x][$object->y][$object->name] = $object;
    }

    public function remove(Object2D $object)
    {
        unset($this->objects[$object->x][$object->y][$object->name]);
    }

    public function getObjects(int $x, int $y)
    {
        return $this->objects[$x][$y] ?? [];
    }
}