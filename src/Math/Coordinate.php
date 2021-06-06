<?php

namespace App\Math;

class Coordinate
{
    public function __construct(
        public string $name, 
        public int $value
    ) { }
}