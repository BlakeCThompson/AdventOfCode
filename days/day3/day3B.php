<?php

$tobagganPosition = 0;
$treesEncountered = 0;
$hillMap = fopen("tobogganHill", "r") or die("Unable to open file!");

$numValidPws = 0;
$row = 0;
//find number of lines that follow a preceding rule.
while (!feof($hillMap)) {
    if ($currentLine = fgets($hillMap)) {
        $row++;
        $validChars =str_split($currentLine);
        $currentPosition = str_split($currentLine)[$tobagganPosition];

        if ($currentPosition != "\r" && $currentPosition != "\n") {
            //echo($row . " " . $tobagganPosition . " " . $currentPosition . "\n");
            if ($currentPosition == "#") {
                $treesEncountered++;
            }
            $tobagganPosition = ($tobagganPosition + 3) % (count(str_split($currentLine))-2);
        }
    }
}
echo($treesEncountered);