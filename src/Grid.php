<?php

namespace App;

class Grid
{
    protected array $self;

    /** @param array<Edge> $edges */
    public function __construct(array $edges) {
        foreach ($edges as $edge) {
            $this->self[$edge->direction->letter] = $edge;
        }
    }

    public function __get(string $letter): Edge
    {
        return $this->self[$letter];
    }
}