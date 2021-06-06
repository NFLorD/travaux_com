<?php

namespace App\Math;

class Plane
{
    /** @param array<Direction> $directions */
    public function __construct(array $directions)
    {
        $previous = end($directions);
        reset($directions);

        foreach ($directions as $current) {
            $current->left = $previous;
            $previous->right = $current;
            $previous = $current;
        }
    }
}