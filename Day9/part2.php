<?php

namespace Aoc2025\Day9;




function part2(): void
{
    $input = file("Day9/example.txt", FILE_IGNORE_NEW_LINES) or die("File not found");

    $points = array_map(fn($x) => explode(",", $x), $input);

    $maxX = $maxY = 0;
    $minY = $minX = 9999999999999999999999999;

    foreach ($points as $point) {
        [$x, $y] = $point;
        $x = intval($x);
        $y = intval($y);

        if ($x > $maxX) {
            $maxX = $x;
        } elseif ($x < $minX) {
            $minX = $x;
        }

        if ($y > $maxY) {
            $maxY = $y;
        } elseif ($y < $minY) {
            $minY = $y;
        }
    }

    $maxArea = 0;
    /* echo (isWall(7, 2, $points) ? "true" : "false"); */
    /* echo(isEnclosed(3,4,$minX, $maxX, $minY, $maxY, $points)?"true":"false"); */

    /* echo (isValidRectangle([9, 5], [2, 3], $minX, $maxX, $minY, $maxY, $points)?"true":"false"); */
    /* echo ("\n"); */



    for ($i = 0; $i < count($points) - 1; $i++) {
        for ($j = $i + 1; $j < count($points); $j++) {

            $area = area($points[$i], $points[$j]);
            /* print($j . "\n"); */
            if ($area > $maxArea && isValidRectangle($points[$i], $points[$j], $minX, $maxX, $minY, $maxY, $points)) {
                $maxArea = $area;
            }
        }
    }

    print_r("$maxArea\n");
}


/* function getWalls($points): array */
/* { */
/*     $walls = []; */
/*     for ($i = 0; $i < count($points) - 1; $i++) { */
/*         for ($j = $i + 1; $j < count($points); $j++) { */
/*             connectPoints($walls, $points[$i], $points[$j]); */
/*         } */
/*     } */
/**/
/*     connectPoints($walls, $points[0], $points[count($points)-1]); */
/**/
/*     return $walls; */
/* } */

/* function connectPoints(&$walls, $p1, $p2) */
/* { */
/*     [$x1, $y1] = $p1; */
/*     [$x2, $y2] = $p2; */
/**/
/*     $x1 = intval($x1); */
/*     $y1 = intval($y1); */
/*     $x2 = intval($x2); */
/*     $y2 = intval($y2); */
/**/
/*     if ($x1 === $x2) { */
/*         for ($y = min($y1, $y2); $y <= max($y1, $y2); $y++) { */
/*             $walls[] = [$x1, $y]; */
/*         } */
/*     } else { */
/*         for ($x = min($x1, $x2); $x <= max($x1, $x2); $x++) { */
/*             $walls[] = [$x, $y1]; */
/*         } */
/*     } */
/* } */


$isWall = [];
function isWall($x, $y, $points): bool
{
    global $isWall;

    if (isset($isWall[$y]) && isset($isWall[$y][$x])) {
        return $isWall[$y][$x];
    }

    for ($i = 0; $i < count($points) - 1; $i++) {
        [$x1, $y1] = $points[$i];
        [$x2, $y2] = $points[$i + 1];

        $x1 = intval($x1);
        $x2 = intval($x2);
        $y1 = intval($y1);
        $y2 = intval($y2);


        if ($x1 === $x2 && $x === $x1 && $y >= min($y1, $y2) && $y <= max($y1, $y2)) {
            $isWall[$y][$x] = true;
            return true;
        }

        if ($y1 === $y2 && $y === $y1 && $x >= min($x1, $x2) && $x <= max($x1, $x2)) {
            $isWall[$y][$x] = true;
            return true;
        }
    }


    [$x1, $y1] = $points[0];
    [$x2, $y2] = $points[count($points) - 1];

    $x1 = intval($x1);
    $x2 = intval($x2);
    $y1 = intval($y1);
    $y2 = intval($y2);

    if ($x1 === $x2 && $x === $x1 && $y >= min($y1, $y2) && $y <= max($y1, $y2)) {
        $isWall[$y][$x] = true;
        return true;
    }

    if ($y1 === $y2 && $y === $y1 && $x >= min($x1, $x2) && $x <= max($x1, $x2)) {
        $isWall[$y][$x] = true;
        return true;
    }


    $isWall[$y][$x] = false;
    return false;
}

$enclosed = [];
function isEnclosed($x, $y, $minX, $maxX, $minY, $maxY, $points)
{
    global $enclosed;

    if (isset($cached[$y]) && isset($cached[$y][$x])) {
        return $enclosed[$y][$x];
    }


    $x = intval($x);
    $y = intval($y);


    $visited = [];
    $toVisit = [[$x, $y]];

    $walls = [];

    while (count($toVisit) > 0) {

        [$currX, $currY] = array_pop($toVisit);
        /* echo(count($visited) . "\n"); */

        if (in_array([$currX, $currY], $visited)) {
            continue;
        } else {
            $visited[] = [$currX, $currY];
        }

        if ($currX > $maxX || $currX < $minX || $currY > $maxY || $currY < $minY) {
            $enclosed[$y][$x] = false;
            return false;
        }

        if (!in_array([$x, $y], $walls) && !isWall($currX, $currY, $points)) {
            /* echo ("$currX,$currY\n"); */
            for ($i = $currX - 1; $i <= $currX + 1; $i++) {
                for ($j = $currY - 1; $j <= $currY + 1; $j++) {
                    if ($i === $currX && $j === $currY) {
                        continue;
                    }

                    $toVisit[] = [$i, $j];
                }
            }
        }
    }

    $enclosed[$y][$x] = true;
    return true;
}

function isValidRectangle($start, $end, $minX, $maxX, $minY, $maxY,  $points)
{
    [$x1, $y1] = $start;
    [$x2, $y2] = $end;

    if ($x1 > $x2) {
        $t = $x1;
        $x1 = $x2;
        $x2 = $t;
    }

    if ($y1 > $y2) {
        $t = $y1;
        $y1 = $y2;
        $y2 = $t;
    }

    /* for ($x = $x1; $x <= $x2; $x++) { */
    /*     for ($y = $y1; $y <= $y2; $y++) { */
    /*         $correct = False; */
    /*         for ($currX = $x; $x <= $maxX; $currX++) { */
    /*             if (isWall($currX, $y, $points)) { */
    /*                 $correct = True; */
    /*                 break; */
    /*             } */
    /*         } */
    /**/
    /*         if (!$correct) { */
    /*             for ($currX = $x; $x >= $minX; $currX--) { */
    /*                 if (isWall($currX, $y, $points)) { */
    /*                     $correct = True; */
    /*                     break; */
    /*                 } */
    /*             } */
    /*         } */
    /**/
    /*         if (!$correct) { */
    /*             for ($currY = $y; $y >= $minY; $currY--) { */
    /*                 if (isWall($x, $currY, $points)) { */
    /*                     $correct = True; */
    /*                     break; */
    /*                 } */
    /*             } */
    /*         } */
    /**/
    /*         if (!$correct) { */
    /*             for ($currY = $y; $y <= $maxY; $currY++) { */
    /*                 if (isWall($x, $currY, $points)) { */
    /*                     $correct = True; */
    /*                     break; */
    /*                 } */
    /*             } */
    /*         } */
    /**/
    /*         if (!$correct) { */
    /*             return false; */
    /*         } */
    /*     } */
    /* } */
    /**/

    for ($x = $x1; $x <= $x2; $x++) {
        for ($y = $y1; $y <= $y2; $y++) {
            if (!isWall($x, $y, $points) && !isEnclosed($x, $y, $minX, $maxX, $minY, $maxY, $points)) {
                /* echo ("$x, $y\n"); */
                return false;
            }
        }
    }

    return true;
}

function printMap($map)
{
    foreach ($map as $row) {
        foreach ($row as $isBound) {
            echo ($isBound ? "#" : ".");
        }
        echo "\n";
    }
}
