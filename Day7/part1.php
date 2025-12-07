<?php
namespace Aoc2025\Day7;

function part1(){
    $input = file("Day7/example.txt", FILE_IGNORE_NEW_LINES) or die("File not found");

    $srcPos = strpos($input[0], "S");
    $beamsPos = [$srcPos];
    $maxPos = strlen($input[0])-1;

    $score = 0;
    for ($row = 2; $row < count($input); $row++){
        $toRemove = [];
        $toAdd = [];
        print_r($beamsPos);
        foreach($beamsPos as $i => $pos){
            if ($input[$row][$pos]=== "^"){
                $score++;
                $toAdd[] =max(0,$pos-1); 
                $toAdd[] =min($maxPos, $pos+1); 
                $toRemove[] = $pos;
            }
        }

        foreach($toRemove as $pos){
            array_splice($beamsPos, array_search($pos, $beamsPos),1);
        }

        foreach($toAdd as $pos){
            if(!in_array($pos, $beamsPos)){
                $beamsPos[] = $pos;
            }
        }
    }

    print_r("$score \n");
}
