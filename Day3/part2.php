<?php

namespace Aoc2025\Day3;


const digitsInNumber=12;

function part2(): void
{
    $input = file("Day3/input.txt", FILE_IGNORE_NEW_LINES) or die("File not found");

    $output = 0;

    foreach ($input as $line) {
        $lastDigitI = -1;
        $number = 0;
        for ($digitIndex = 0; $digitIndex < digitsInNumber; $digitIndex++) {
            $max = -1;

            for ($i = $lastDigitI+1; $i < strlen($line) - digitsInNumber + $digitIndex + 1; $i++) {
                $value = intval($line[$i]);
                if ($value > $max) {
                    $max = $value;
                    $lastDigitI = $i;
                }
            }
            $number += pow(10,digitsInNumber - $digitIndex - 1) * $max;
        }
        $output += $number;
    }

    echo $output . PHP_EOL;
}
