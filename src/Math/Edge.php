<?php

namespace App\Math;

class Edge
{
    public function __construct(
        public Axis $axis,
        public Direction $direction,
        public int $value
    ) { }
}