<?php

namespace App\Math;

class Axis
{
    public function __construct(
        public string $name,
        public PlusDirection $plus,
        public MinusDirection $minus,
    ) {
        $plus->axis = $this;
        $minus->axis = $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}