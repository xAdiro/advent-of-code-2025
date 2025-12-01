<?php

namespace Aoc2025\Day1;

function part1()
{
    $input = file("Day1/input.txt", FILE_IGNORE_NEW_LINES) or die("File not found");


    $position = 50;
    $output = 0;

    foreach ($input as $line) {
        $direction = $line[0];
        $value = intval(substr($line, 1));
        if ($direction === "L") {
            $position -= $value;
        } else {
            $position += $value;
        }
        $position = ($position + 100) % 100;

        if ($position === 0) {
            $output++;
        }
    }

    echo $output . "\n";
}


function part2()
{
    $input = file("Day1/input.txt", FILE_IGNORE_NEW_LINES) or die("File not found");


    $position = 50;
    $output = 0;

    foreach ($input as $line) {
        $direction = $line[0];
        $value = intval(substr($line, 1));
        if ($direction === "L") {
            $value = -$value;
        }

        $newPosition = $position + $value;
        if ($newPosition < 0){
            if ($position !== 0) $output++;
            $output += (int)abs($newPosition / 100);
            if ($newPosition % 100 == 0) $output--;
        } elseif ($newPosition > 0) {
            $output += (int)abs($newPosition / 100);
            if ($newPosition % 100 == 0) $output--;
        }

        $position = (($newPosition + 100) % 100 + 100) % 100;
        if ($position == 0){
            $output++;
        }
    }

    echo $output . "\n";
}
