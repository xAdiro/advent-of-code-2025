<?php
namespace Aoc2025\Day9;

function part1(): void{
    $input = file("Day9/input.txt", FILE_IGNORE_NEW_LINES) or die("File not found");

    $points = array_map(fn($x) => explode(",", $x), $input);

    $maxArea = 0;

    for ($i =0; $i < count($points)-1; $i++){
        for ($j = $i+1;$j<count($points);$j++){
            $area = area($points[$i], $points[$j]);
            if ($area > $maxArea){
                $maxArea = $area;
            }
        }
    }

    sort($areas);

    print_r($areas);


    print("$maxArea \n");
}

function area(array $p1, array $p2){
    
    [$x1, $y1] = $p1;
    [$x2, $y2] = $p2;

    return (abs(intval($x1) - intval($x2)) + 1) * (abs(intval($y1) - intval($y2)) + 1);
}
