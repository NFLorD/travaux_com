<?php

namespace App\Tests;

use App\Exception\OverlapException;
use App\Solution;
use Exception;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

class SolutionTest extends TestCase
{
    public function testHandlesMultipleRovers()
    {
        $input = $this->getDataset('handlesMultipleRovers');

        $output = Solution::solve($input);
        $roversCount = count(explode(PHP_EOL, $output));

        $this->assertEquals(3, $roversCount);
    }

    public function testThrowsOnOutOfBounds()
    {
        $input = $this->getDataset('throwsOnOutOfBounds');
        $thrown = false;

        try {
            Solution::solve($input);
        } catch (OutOfBoundsException $exception) {
            $thrown = true;
        }

        $this->assertTrue($thrown);
    }

    public function testThrowsOnWrongPosition()
    {
        $input = $this->getDataset('throwsOnWrongPosition');
        $thrown = false;

        try {
            Solution::solve($input);
        } catch (OutOfBoundsException $exception) {
            $thrown = true;
        }

        $this->assertTrue($thrown);
    }

    public function testThrowsOnOverlap()
    {
        # First case, a rover moves towards an already occupied cell
        $input = $this->getDataset('throwsOnOverlap.first');
        $thrown = false;

        try {
            Solution::solve($input, false);
        } catch (OverlapException $exception) {
            $thrown = true;
        }

        $this->assertTrue($thrown);

        # Second case, a rover is positionned on an already occupied cell
        $input = $this->getDataset('throwsOnOverlap.second');
        $thrown = false;

        try {
            Solution::solve($input, false);
        } catch (OverlapException $exception) {
            $thrown = true;
        }

        $this->assertTrue($thrown);
    }

    public function testIsCorrect()
    {
        $input = $this->getDataset('isCorrect');
        $expectedOutput = $this->getDataset('isCorrect', 'output');

        $output = Solution::solve($input);
        $this->assertEquals($expectedOutput, $output);
    }

    protected function getDataset(string $name, string $type = 'input')
    {
        return file_get_contents(__DIR__."/datasets/$name.$type.txt");
    }
}