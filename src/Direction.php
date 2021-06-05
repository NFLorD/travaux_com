<?php

namespace App;

class Direction
{
    public Direction $right;
    public Direction $left;

    public function __construct(
        public string $letter
    ) { }
}