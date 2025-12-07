<?php
namespace Aoc2025\Day6;


function part1(){
    $input = file("Day6/input.txt", FILE_IGNORE_NEW_LINES) or die("File not found");
    $input = array_map(fn($x) => trim(preg_replace('/\s+/', ' ', $x)), $input);
    $input = array_map(fn($x) => explode(" ", $x), $input);

    $score = 0;
    for($col=0; $col < count($input[0]); $col++){
        $result = $input[0][$col];
        for($row=1;$row<count($input)-1;$row++){
            $result = mathOperation($result,$input[$row][$col], $input[count($input)-1][$col]);
        }
        $score += $result;
    }

    print_r($score . PHP_EOL);
}

function mathOperation(int $x, int $y, string $operation){

    if ($operation === "+"){
        return $x + $y;

    }
    elseif ($operation === "*"){
        return $x * $y;
    }
}
