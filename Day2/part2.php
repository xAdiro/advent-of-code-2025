<?php
namespace Aoc2025\Day2;

function part2(){
    $input = file("Day2/example.txt", FILE_IGNORE_NEW_LINES)[0] or die("File not found");

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
            if (containsRepeatingDigits(strval($i))) {
                $result += $i;
            }
        }
    }

    print_r($result);
}

function containsRepeatingDigits(string $x): bool
{
    for ($seriesLen = 1; $seriesLen < strlen($x); $seriesLen++) {
        if (containsRepeatingDigitsLen($x, $seriesLen)) return true;
    }
    return false;
}

function containsRepeatingDigitsLen(string $x, int $seriesLen)
{
    if (strlen($x) % $seriesLen !== 0) return false;

    for ($start = 0; $start < $seriesLen; $start++) {
        $currDigit = $x[$start];

        for ($i = $start; $i < strlen($x); $i += $seriesLen) {
            if ($x[$i] !== $currDigit) {
                return false;
            }
        }
    }

    return true;
}
