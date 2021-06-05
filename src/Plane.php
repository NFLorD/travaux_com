<?php

namespace App;

class Plane
{
    protected array $self;

    /** @param array<Direction> $directions */
    public function __construct(array $directions)
    {
        $previous = end($directions);
        reset($directions);

        foreach ($directions as $current) {
            $current->left = $previous;
            $previous->right = $current;
            $previous = $current;

            $this->self[$current->letter] = $current;
        }
    }

    public function __get(string $letter): Direction
    {
        return $this->self[$letter];
    }
}