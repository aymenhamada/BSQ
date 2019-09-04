<?php

if(isset($argv[1])){
    $check = fopen($argv[1].'.txt', 'r') || die("Unable to open file!");
    $path = $argv[1].'.txt';
    readPlate($path);
}else{
    echo "Veuillez mettre un chemin de fichier texte en deuxième paramètre\n";
}

function readPlate($path){
    $plan = fopen($path, 'r');
    while(! feof($plan))  {
        $myMap[] = trim(fgets($plan));
    }

    //transforms the map into a number of 0 and 1(easier to find the biggest square this way)
    for($i = 1; $i < count($myMap); $i++){
        for($j = 0; $j < strlen($myMap[$i]); $j++){
             if($myMap[$i][$j] == 'o'){
                $mapWithNumbers[$i][$j] = 0;
             }
             else{
                $mapWithNumbers[$i][$j] = 1;
             }
        }
    }

    giveMeSolution($mapWithNumbers);
    findThePosition($mapWithNumbers, $myMap);

    for($i = 1; $i < count($myMap); $i++){
        echo $myMap[$i]."\n";
    }
}


function giveMeSolution(array &$mapWithNumbers){
    for($i = 1; $i < count($mapWithNumbers); $i++){
        for($j = 0; $j < count($mapWithNumbers[$i]); $j++){
            if($i  == 1 || $j == 0 ){
                continue;
            }
            else if($mapWithNumbers[$i][$j] > 0){
                $mapWithNumbers[$i][$j] = 1 + min([$mapWithNumbers[$i][$j - 1],
                                        $mapWithNumbers[$i - 1][$j],
                                        $mapWithNumbers[$i - 1][$j - 1]]);
            }
        }
    }
}

function findThePosition(&$mapWithNumbers, &$myMap){
    $max = 0;
    $positon = [];

    for($i = 1; $i < count($mapWithNumbers); $i++){
        for($j = 0; $j < count($mapWithNumbers[$i]); $j++){
            if($mapWithNumbers[$i][$j] >= $max){
                if($mapWithNumbers[$i][$j] == $max && !empty($positon)){
                    if($positon[0][1] > $j){
                        $max = $mapWithNumbers[$i][$j];
                        $positon[0][0] = $i;
                        $positon[0][1] = $j;
                        continue;
                    }
                    else{
                        continue;
                    }
                }
                $max = $mapWithNumbers[$i][$j];
                $positon[0][0] = $i;
                $positon[0][1] = $j;
            }
        }
    }
    return drawMyCrossedMap($myMap, $positon, $max);
}


function drawMyCrossedMap(&$myMap, $positon, $occurence){
    for($i = $positon[0][0]; $i > $positon[0][0] - $occurence; $i--){
        for($j = $positon[0][1]; $j > $positon[0][1] - $occurence; $j--){
            $myMap[$i][$j] = "X";
        }
    }
}