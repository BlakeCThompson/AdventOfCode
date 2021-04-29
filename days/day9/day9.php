<?php
require_once "Last25.php";
$filename = "data";
$data = file_get_contents($filename);
$data = explode(PHP_EOL, $data);
//twentyfive
$tf = [];
for ($i = 0; $i < 25; $i++) {
    array_push($tf, $data[$i]);
}
$tf = new Last25($tf);
$brokenElement;
$i;
for ($i = 25; $i < count($data); $i++) {
    try {
        $tf->array_push($data[$i]);
    } catch (ErrorException $error) {
        print($error->getMessage());
        $brokenElement = $data[$i];
        break;
    }
}
require_once "CorrespondingFinder.php";
array_splice($data,0,$i);
$correspondingFinder = new CorrespondingFinder($data,$brokenElement);