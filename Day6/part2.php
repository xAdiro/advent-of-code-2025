<?php
namespace Aoc2025\Day6;


function part2(){
    $input = file("Day6/input.txt", FILE_IGNORE_NEW_LINES) or die("File not found");
    /* $input = array_map(fn($x) => trim(preg_replace('/\s+/', ' ', $x)), $input); */
    /* $input = array_map(fn($x) => explode(" ", $x), $input); */
    $input[count($input)-1] = trim(preg_replace('/\s+/', ' ', $input[count($input)-1]));

    fillDigits($input);
    $input = array_map(fn($x) => explode(" ", $x), $input);

    print_r($input);

    $score = 0;
    for ($col = 0; $col < count($input[0]); $col++){
        $result = $input[count($input)-1][$col] === "+" ? 0 : 1;

        for($digitI = 0; $digitI < strlen($input[0][$col]); $digitI++){
            $number = "";
            for($row = 0; $row < count($input); $row++){
                if($input[$row][$col][$digitI] === "#"){ continue;}
                $number .= $input[$row][$col][$digitI];
            }

            $result = mathOperation(intval($result), intval($number), $input[count($input)-1][$col]);
        }
        $score += $result;
    }

    print_r($score);
}

function fillDigits(array &$input){
    for($col = 0; $col<strlen($input[0]); $col++){
        $isDigit = false;
        for($row = 0; $row < count($input) -1; $row++){
            if ($input[$row][$col] !== " "){
                $isDigit = true;
                break;
            }
        }

        if ($isDigit){
            for($row =0; $row<count($input)-1; $row++){
                if ($input[$row][$col] === " "){
                    $input[$row][$col] = "#";
                }
            }
        }
    }
}
