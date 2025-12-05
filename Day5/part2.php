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

    usort(
        $freshRanges,
        function ($a, $b) {
            if ($a["min"] === $b["min"]) return 0;

            return $a["min"] < $b["min"] ? -1 : 1;
        }
    );

    fixRanges($freshRanges);


    $freshCount = 0;

    foreach ($freshRanges as $idRange) {
        $freshCount += $idRange["max"] - $idRange["min"] + 1;
    }

    print_r("$freshCount \n");
}


function fixRanges(&$ranges)
{
    $changed = true;
    while ($changed) {
        $changed = false;

        for ($i = 0; $i < count($ranges) - 1; $i++) {
            if ($ranges[$i]["max"] >= $ranges[$i + 1]["min"]) {
                if ($ranges[$i]["max"] >= $ranges[$i + 1]["max"]) {
                    array_splice($ranges,$i+1,1);
                    $changed = true;
                    break;
                } else {
                    $ranges[$i]["max"] = $ranges[$i + 1]["min"] - 1;
                    $changed = true;
                }
            }
        }
    }
}
