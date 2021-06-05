<?php

namespace App;

class Edge
{
    public function __construct(
        public Direction $direction,
        public int $value
    ) { }
}