<?php

namespace Aoc2025\Day2;


function part1()
{
    $input = file("Day2/input.txt", FILE_IGNORE_NEW_LINES)[0] or die("File not found");

    $ranges = explode(",", $input);

    $ranges = array_map(function ($x) {
        [$min, $max] =  explode("-", $x);
        return [
            "min" => $min,
            "max" => $max
        ];
    }, $ranges);

    $result = 0;

    foreach ($ranges as $range) {
        $min = intval($range["min"]);
        $max = intval($range["max"]);

        for ($i = $min; $i <= $max; $i++) {
            if (isRepeating(strval($i))) {
                $result += $i;
            }
        }
    }

    print_r($result);
}

function isRepeating(string $x): bool{
    if (strlen($x) % 2 !== 0) return false;

    for($i =0; $i<intdiv(strlen($x),2);$i++){
        if ($x[$i] != $x[$i+intdiv(strlen($x),2)]){
            return false;
        }
    }
    return true;
}

