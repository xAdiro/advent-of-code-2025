<?php

namespace Aoc2025\Day5;



function part2()
{
    $input = file("Day5/input.txt", FILE_IGNORE_NEW_LINES) or die("File not found");


    $freshRanges = [];

    foreach ($input as $line) {
        if ($line === "") {
            break;
        }

        $rangeEnds = explode("-", $line);
        $freshRanges[] = [
            "min" => intval($rangeEnds[0]),
            "max" => intval($rangeEnds[1])
        ];
    }

    $freshIds = [];


    foreach($freshRanges as $idRange){
        for($i = $idRange["min"]; $i<= $idRange["max"]; $i++){
            if (!in_array($i, $freshIds)){
                $freshIds[] = $i;
            }
        }

    }

    print_r(count($freshIds) . PHP_EOL);
}
