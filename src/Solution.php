<?php

namespace App;

class Solution
{
    public static function solve(string $input, bool $allowOverlapping = false): string
    {
        $lines = explode("\n", $input);
        $lines = array_map('trim', $lines);

        [$width, $height] = explode(' ', array_shift($lines));
        $simulation = new Simulation2D($width, $height, $allowOverlapping);

        $output = '';
        for ($i = 0; $i < count($lines); $i++) {
            [$x, $y, $orientation] = explode(' ', $lines[$i]);
            $instructions = str_split($lines[++$i]);
            
            $rover = $simulation->addRover((int) $x, (int) $y, $orientation);
            foreach ($instructions as $instruction) {
                $simulation->process($instruction, $rover);
            }

            $output .= "{$rover->x} {$rover->y} {$rover->orientation->name}\n";
        }

        $output = rtrim($output);

        return $output;
    }
}