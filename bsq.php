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
                $myCopy[$i][$j] = 0;
             }
             else{
                $myCopy[$i][$j] = 1;
             }
        }
    }

    giveMeSolution($myCopy);
    findThePosition($myCopy, $myMap);

    for($i = 1; $i < count($myMap); $i++){
        echo $myMap[$i]."\n";
    }
}


function giveMeSolution(array &$myMap){
    for($i = 1; $i < count($myMap); $i++){
        for($j = 0; $j < count($myMap[$i]); $j++){
            if($i  == 1 || $j == 0 ){
                continue;
            }
            else if($myMap[$i][$j] > 0){
                $myMap[$i][$j] = 1 + min([$myMap[$i][$j - 1],
                                        $myMap[$i - 1][$j],
                                        $myMap[$i - 1][$j - 1]]);
            }
        }
    }
}

function findThePosition(&$myMap, &$myCopy){
    $max = 0;
    $positon = [];

    for($i = 1; $i < count($myMap); $i++){
        for($j = 0; $j < count($myMap[$i]); $j++){
            if($myMap[$i][$j] >= $max){
                if($myMap[$i][$j] == $max && !empty($positon)){
                    if($positon[0][1] > $j){
                        $max = $myMap[$i][$j];
                        $positon[0][0] = $i;
                        $positon[0][1] = $j;
                        continue;
                    }
                    else{
                        continue;
                    }
                }
                $max = $myMap[$i][$j];
                $positon[0][0] = $i;
                $positon[0][1] = $j;
            }
        }
    }
    return drawMyCrossedMap($myCopy, $positon, $max);
}


function drawMyCrossedMap(&$myCopy, $positon, $occurence){
    for($i = $positon[0][0]; $i > $positon[0][0] - $occurence; $i--){
        for($j = $positon[0][1]; $j > $positon[0][1] - $occurence; $j--){
            $myCopy[$i][$j] = "X";
        }
    }
}