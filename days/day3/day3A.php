<?php

$tobagganPosition = 0;
$treesEncountered = 0;
$hillMap = fopen("tobogganHill", "r") or die("Unable to open file!");

//find number of lines that follow a preceding rule.
while (!feof($hillMap)) {
    //get next line, if it exists.
    if ($currentLine = fgets($hillMap)) {

        $validChars = str_split($currentLine);
        $currentPosition = str_split($currentLine)[$tobagganPosition];

        //echo($row . " " . $tobagganPosition . " " . $currentPosition . "\n");
        if ($currentPosition == "#") {
            $treesEncountered++;
        }
        //the position moves three to the right on every row. If we reach the end of the line, the position resets.
        //We decrease the count of the line by two, because every row is appended with newline characters \r,\n
        if ($tobagganPosition + 3 != $tobagganPosition + 3 % (count(str_split($currentLine)) - 2)) {
            print("something");
        }
        $tobagganPosition = ($tobagganPosition + 3) % (count(str_split($currentLine)) - 2);
    }

}
echo($treesEncountered);