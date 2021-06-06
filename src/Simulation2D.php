<?php

namespace App;

use App\Exception\OverlapException;
use App\Math\Axis;
use App\Math\Coordinate;
use App\Math\Edge;
use App\Math\Grid;
use App\Math\MinusDirection;
use App\Math\Operation;
use App\Math\Plane;
use App\Math\PlusDirection;
use Exception;
use OutOfBoundsException;

class Simulation2D
{
    public const NORTH = 'N';
    public const EAST = 'E';
    public const SOUTH = 'S';
    public const WEST = 'W';

    public const CARDINAL_DIRECTIONS = [self::NORTH, self::EAST, self::SOUTH, self::WEST];

    public const X_AXIS = 'x';
    public const Y_AXIS = 'y';

    public const ROTATE_LEFT = 'L';
    public const ROTATE_RIGHT = 'R';
    public const MOVE_FORWARD = 'M';

    public Grid $grid;
    public int $count = 0;

    public function __construct(
        int $width, int $height, 
        public bool $allowOverlapping = false
    ) {
        $x = new Axis(self::X_AXIS,
            $east = new PlusDirection(self::EAST),
            $west = new MinusDirection(self::WEST)
        );
        $y = new Axis(self::Y_AXIS,
            $north = new PlusDirection(self::NORTH),
            $south = new MinusDirection(self::SOUTH)
        );

        new Plane([
            $y->plus,
            $x->plus,
            $y->minus,
            $x->minus
        ]);

        $this->grid = new Grid([
            new Edge($x, $east, $width),
            new Edge($x, $west, 0),
            new Edge($y, $north, $height), 
            new Edge($y, $south, 0)
        ]);
    }

    public function addRover(int $x, int $y, string $orientation): Rover
    {
        if (!in_array($orientation, self::CARDINAL_DIRECTIONS)) {
            throw new Exception("No such direction: $orientation");
        }

        if (!$this->allowOverlapping && 0 !== count($this->grid->getObjects($x, $y))) {
            throw new OverlapException("Objects overlapping on: ($x, $y)");
        }

        $lower = $this->grid->{self::WEST}->value;
        $upper = $this->grid->{self::EAST}->value;
        if (!Operation::inRange($x, $lower, $upper)) {
            throw new OutOfBoundsException("Out of bounds ($lower, $upper): $x");
        }

        $lower = $this->grid->{self::SOUTH}->value;
        $upper = $this->grid->{self::NORTH}->value;
        if (!Operation::inRange($y, $lower, $upper)) {
            throw new OutOfBoundsException("Out of bounds ($lower, $upper): $y");
        }

        $rover = new Rover(
            (string) ++$this->count, 
            new Coordinate(self::X_AXIS, $x),
            new Coordinate(self::Y_AXIS, $y),
            $this->grid->{$orientation}->direction
        );

        $this->grid->add($rover);

        return $rover;
    }
    
    public function process(string $instruction, Rover $rover)
    {
        // echo "\n#$rover->name ($rover->x, $rover->y, {$rover->orientation->name}) IN=$instruction\n";
        switch ($instruction)
        {
            case self::MOVE_FORWARD:
                $this->processForwardMove($rover);
                break;
            case self::ROTATE_LEFT:
            case self::ROTATE_RIGHT:
                $this->processRotation($rover, $instruction);
                break;
            default:
                throw new Exception("Unknown instruction: \"$instruction\"");
        }
    }
    
    protected function processForwardMove(Rover $rover)
    {
        $direction = $rover->orientation;
        switch (get_class($direction)) {
            case PlusDirection::class:
                $operation = 'increment';
                break;
            case MinusDirection::class:
                $operation = 'decrement';
                break;
        }

        $axis = $direction->axis;
        $newValue = Operation::{$operation}($rover->{$axis->name});

        $lower = $this->grid->{$axis->minus->name}->value;
        $upper = $this->grid->{$axis->plus->name}->value;
        if (!Operation::inRange($newValue, $lower, $upper)) {
            throw new OutOfBoundsException("Out of bounds in {$axis->name} ($lower, $upper): $newValue");
        }

        $coordinates = $rover->coordinates;
        $coordinates[$axis->name] = $newValue;

        $x = $coordinates[self::X_AXIS];
        $y = $coordinates[self::Y_AXIS];
        if (!$this->allowOverlapping && 0 !== count($this->grid->getObjects($x, $y))) {
            $objects = $this->grid->getObjects($x, $y);
            $obj = array_shift($objects);
            throw new OverlapException("Objects overlapping on: ({$rover->x}, {$rover->y})");
        }

        $this->grid->remove($rover);

        $rover->{$axis->name} = $newValue;
        $this->grid->add($rover);
    }

    protected function processRotation(Rover $rover, string $instruction)
    {
        $rotation = self::ROTATE_LEFT === $instruction ? 'left' : 'right';
        $rover->orientation = $rover->orientation->{$rotation};
    }
}