<?php

    if(count($argv) != 4){
        echo "Program x y density\n";
        exit;
    }

$x = $argv[1];
$y = $argv[2];
$density = $argv[3];
$i = 0;
$j = 0;

$str = '';
$str .= $y . "\n";

while($i < $y){
    $j = 0;
    while($j < $x){
        if(rand(0, $y - 1) * 2 < $density){
            $str .= "o";
        }
        else{
             $str .= ".";
        }
        $j++;
    }
    $str .= "\n";
    $i++;
}

file_put_contents('test.txt', $str);