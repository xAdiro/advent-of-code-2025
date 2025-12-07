<?php
namespace Aoc2025\Day7;

function part2(){
    $input = file("Day7/input.txt", FILE_IGNORE_NEW_LINES) or die("File not found");

    $srcPos = strpos($input[0], "S");
    $beamPos = $srcPos;
    /* $maxPos = strlen($input[0])-1; */

    print_r(calcPaths($beamPos, 2, $input));
}

$CALCED = [];


function calcPaths(int $beamPos, int $row, $input){
    global $CALCED;
    if ($row >= count($input)-1) {
        return 1;
    }

    $result = null;

    if ($input[$row][$beamPos] === "^"){
        $cached = $CALCED[$row][$beamPos];
        if($cached !== null){
            return $cached;
        }

        $result = calcPaths($beamPos -1, $row+2, $input) + calcPaths($beamPos +1, $row+2, $input);

    }
    else {
        $result =  calcPaths($beamPos, $row+2, $input);
    }

    $CALCED[$row][$beamPos] = $result;
    return $result;
}
