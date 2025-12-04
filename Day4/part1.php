<?php

namespace Aoc2025\Day4;


function part1(): void
{
    $input = file("Day4/input.txt", FILE_IGNORE_NEW_LINES) or die("File not found");


    $score = 0;
    for ($i = 0; $i < strlen($input[0]); $i++){
        for ($j =0; $j < count($input); $j++){
            if ($input[$j][$i] === "@" && calcNeigbours($input, $i, $j) <4){
                $score++;
            }
        }
    }

    print_r($score . "\n");
}

function calcNeigbours(array $input, int $x, int $y): int
{

    $minX = 0;
    $maxX = strlen($input[0]) - 1;
    $minY = 0;
    $maxY = count($input) - 1;

    if ($x > 0) {
        $minX = $x - 1;
    }

    if ($y > 0){
        $minY = $y -1;
    }

    if ($x < strlen($input[0])-2){
        $maxX = $x +1;
    }


    if ($y < count($input)-2){
        $maxY = $y +1;
    }


    $neighbours = 0;

    for ($i = $minX; $i<=$maxX; $i++){
        for($j=$minY; $j<=$maxY; $j++){
            if ($i === $x && $j === $y) continue;

            if ($input[$j][$i] === "@"){
                $neighbours++;
            }
        }
    }

    return $neighbours;
}
