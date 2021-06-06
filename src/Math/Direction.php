<?php

namespace App\Math;

abstract class Direction
{
    public Axis $axis;

    public Direction $right;
    public Direction $left;
    public Direction $up;
    public Direction $down;

    public function __construct(
        public string $name
    ) { }

    public function __toString()
    {
        return $this->name;
    }
}