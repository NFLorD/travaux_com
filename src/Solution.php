<?php

namespace App;

class Solution
{
    public const NORTH = 'N';
    public const EAST = 'E';
    public const SOUTH = 'S';
    public const WEST = 'W';

    public static function solve(string $input): string
    {
        $plane = new Plane([
            new Direction(self::NORTH), 
            new Direction(self::EAST), 
            new Direction(self::SOUTH), 
            new Direction(self::WEST)
        ]);

        $lines = explode("\n", $input);
        $lines = array_map('trim', $lines);

        [$width, $height] = explode(' ', array_shift($lines));
        $grid = new Grid([
            new Edge($plane->{self::NORTH}, $height), 
            new Edge($plane->{self::EAST}, $width), 
            new Edge($plane->{self::SOUTH}, 0), 
            new Edge($plane->{self::WEST}, 0)
        ]);
        
        $output = '';
        for ($i = 0; $i < count($lines); $i++) {
            [$x, $y, $facing] = explode(' ', $lines[$i]);
            $instructions = str_split($lines[++$i]);
            
            $rover = new Rover(
                (int) $x, (int) $y, $facing, 
                $instructions
            );

            $rover->move($grid);
            $output .= "{$rover->x} {$rover->y} {$rover->facing}\n";
        }

        $output = rtrim($output);

        return $output;
    }
}