<?php

namespace Aoc2025\Day5;

function part1()
{
    $input = file("Day5/input.txt", FILE_IGNORE_NEW_LINES) or die("File not found");


    $freshRanges = [];
    $ingredients = [];

    $afterSeparation = false;
    foreach ($input as $line) {
        if ($line === "") {
            $afterSeparation = true;
            continue;
        }

        if ($afterSeparation) {
            $ingredients[] = intval($line);
        } else {
            $rangeEnds = explode("-", $line);
            $freshRanges[] = [
                "min" => intval($rangeEnds[0]),
                "max" => intval($rangeEnds[1])
            ];
        }
    }

    $freshCount = 0;
    foreach($ingredients as $id){
        foreach($freshRanges as $idRange){
            if ($id >= $idRange["min"] && $id <= $idRange["max"]){
                $freshCount++;
                break;
            }
        }
    }

    print_r($freshCount);
}
