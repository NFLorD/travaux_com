<?php

require_once './vendor/autoload.php';

use App\Solution;

$input = 
"5 5
1 2 N
LMLMLMLMM
3 3 E
MMRMMRMRRM";

$output = Solution::solve($input);

$expectedOutput = 
"1 3 N
5 1 E";

echo "Expected:\n$expectedOutput";
echo "\nReceived:\n$output\n";