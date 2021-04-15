<?php
$rulesFile= "sampleAnswers";
$rawRules = file_get_contents($rulesFile);
$rules = explode(PHP_EOL,$rawRules);
$searchedFor = "shiny gold bag";
$rulesArray = [];
foreach ($rules as $rule) {

}