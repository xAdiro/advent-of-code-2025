<?php
namespace Aoc2025\Day3;


function part1(): void{
    $input = file("Day3/input.txt", FILE_IGNORE_NEW_LINES) or die("File not found");

    $output = 0;

    foreach($input as $line){
        $digit1Index = 0;
        $digit2Index = 0;
        $max = -1;
        for($i = 0; $i < strlen($line) - 1;$i++){
            $value = intval($line[$i]);
            if ($value > $max){
                $max = $value;
                $digit1Index = $i;
            }
        }

        $max2 = -1;
        for($i = $digit1Index+1; $i < strlen($line); $i++){
            $value = intval($line[$i]);
            if ($value > $max2){
                $max2 = $value;
                $digit2Index = $i;
            }
        }

        $output += $max * 10 + $max2;
    }

    echo $output;
}
