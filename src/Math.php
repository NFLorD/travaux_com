<?php

namespace App;

class Math
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
}