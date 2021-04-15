<?php
$answerFile= "sampleAnswers";
$answers = file_get_contents($answerFile);
$answerGroups = explode(PHP_EOL.PHP_EOL,$answers);

function numUniqueAnswers($answerGroup){
    $answerArray = str_split($answerGroup);
    $uniqueItems = [];
    foreach ($answerArray as $answer){
        if(preg_match("/[A-Z]/i",$answer)>0 && !in_array($answer,$uniqueItems)){
            array_push($uniqueItems,$answer);
        }
    }
    return count($uniqueItems);
}

function numUnanimousAnswers($answerGroup)
{
    $answerArray = explode(PHP_EOL, $answerGroup);

    //establish baseline of answers.
    $uniqueItems = str_split($answerArray[0]);
    //On every line, we have to ensure that the answers still all exist. If they don't, then need to remove
    //whatever answers are not unanimous.
    if ($uniqueItems) {
        foreach ($answerArray as $individualsAnswers) {

            foreach ($uniqueItems as $uniqueItem) {
                if (!str_contains($individualsAnswers, $uniqueItem)) {
                    $index = array_search($uniqueItem, $uniqueItems);
                    if (count($uniqueItems) == 1) {
                        return 0;
                    }
                    unset($uniqueItems[$index]);
                    $test = "";
                }
            }


        }
        return count($uniqueItems);
    } else return 0;

}
$total = 0;
$totalUnanimous = 0;
foreach ($answerGroups as $answerGroup) {
    $total += numUniqueAnswers($answerGroup);
    $totalUnanimous += numUnanimousAnswers($answerGroup);
}
print("total unique answers: ".$total."\n");
print("total unanimous answers per group: ".$totalUnanimous."\n");