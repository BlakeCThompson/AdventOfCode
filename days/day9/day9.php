<?php
require_once "Last25.php";
$filename = "data";
$data = file_get_contents($filename);
$data = explode(PHP_EOL,$data);
//twentyfive
$tf = [];
for($i=0;$i<25;$i++){
    array_push($tf,$data[$i]);
}
$tf = new Last25($tf);
$brokenElement;
$i;
for($i=25;$i<count($data);$i++){
    try {
        $tf->array_push($data[$i]);
    }catch(ErrorException $error){
        print($error->getMessage());
        $brokenElement = $data[$i];
        break;
    }
}
//search for consecutive numbers up to the broken number that add up to the broken number.
for($j=0; $j<$i; $j++){
    //starting with three, compare every combination of numbers from the list up to i to see if the sum is the broken number.
    //If not found, increase the numbers in each combination by size 1.
    for($k=2; $k < $i; $k++){

        $nums = range($j,$j+$k);
        foreach ($nums as $num) {
            $nums[$num]= $data[$num];
        }
        $count = count($nums);
        //for each
        //move the last element over continuously until the end or match is found.
        $next = $count;
        while($count > 0){
        }
        if($data[$j]+$data[$j+1]+$data[$j+2] == $brokenElement){

        }
    }
}

