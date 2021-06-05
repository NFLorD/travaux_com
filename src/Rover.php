<?php

namespace App;

use OutOfBoundsException;

class Rover
{
    public function __construct(
        public int $x,
        public int $y,
        public string $facing,
        public array $instructions
    ) { }

    public function move(Grid $grid): void
    {
        foreach ($this->instructions as $instruction)
        {
            $currentEdge = $grid->{$this->facing};
            switch ($instruction)
            {
                case 'M':
                    $this->forward($currentEdge);
                    break;
                case 'L':
                case 'R':
                    $direction = 'L' === $instruction ? 'left' : 'right';
                    $this->facing = $currentEdge->direction->{$direction}->letter;
                    break;
            }
        }
    }

    protected function forward(Edge $edge): void
    {
        switch ($this->facing) {
            case 'N':
            case 'E':
                $comparison = 'superior';
                $operation = 'increment';
                $direction = 'N' === $this->facing ? 'y' : 'x';
                break;
            case 'S':
            case 'W':
                $comparison = 'inferior';
                $operation = 'decrement';
                $direction = 'S' === $this->facing ? 'y' : 'x';
                break;
        }

        $this->{$direction} = Math::{$operation}($this->{$direction});
        if (Math::{$comparison}($this->{$direction}, $edge->value)) {
            $value = $this->{$direction};
            throw new OutOfBoundsException("$value is out of bound {$edge->value}");
        }
    }
}