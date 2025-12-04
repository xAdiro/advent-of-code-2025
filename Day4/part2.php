<?php

namespace Aoc2025\Day4;



function part2(): void
{
    $input = file("Day4/input.txt", FILE_IGNORE_NEW_LINES) or die("File not found");


    $score = 0;
    $prevScore = 0;
    while (true) {
        for ($i = 0; $i < strlen($input[0]); $i++) {
            for ($j = 0; $j < count($input); $j++) {
                if ($input[$j][$i] === "@" && calcNeigbours($input, $i, $j) < 4) {
                    $score++;
                    $input[$j][$i] = ".";
                }
            }
        }

        if ($score !== $prevScore){
            $prevScore = $score;
        } else{
            break;
        }
    }


    print_r($score . "\n");
}
