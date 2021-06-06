<?php

namespace App;

use App\Math\Coordinate;
use App\Math\Direction;
use App\Math\Object2D;

class Rover extends Object2D
{
    public function __construct(
        public string $name,
        Coordinate $x,
        Coordinate $y,
        public Direction $orientation
    ) {
        parent::__construct($name, $x, $y);
    }
}