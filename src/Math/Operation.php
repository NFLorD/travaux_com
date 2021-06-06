<?php

namespace App\Math;

class Operation
{
    public static function superior(int $a, int $b): bool
    {
        return $a > $b;
    }

    public static function inferior(int $a, int $b): bool
    {
        return $a < $b;
    }

    public static function increment(int $a): int
    {
        return ++$a;
    }

    public static function decrement(int $a): int
    {
        return --$a;
    }

    public static function inRange(int $x, int $lower, int $upper): bool
    {
        return $lower <= $x && $x <= $upper;
    }
}