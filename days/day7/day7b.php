<?php
require_once "BagTree.php";
//find number of other bags that a specified bag must contain.
$rulesFile = "rules";
$rawRules = file_get_contents($rulesFile);
$ruleLines = explode(PHP_EOL, $rawRules);
//rules is an array of small bag trees.
static $rules = [];


$specBag = "shiny gold";

//strip unnecessary separators and grammar, format into nice array

foreach ($ruleLines as $key => $ruleLine) {
    $rule = explode(" bags contain ", $ruleLine);
    //get every bag within this bag, and add it to the list of bags within parent.

    preg_match("/[0-9]+/", $rule[1], $counts);
    $bags = explode(", ", str_replace([" bags", " bag", "."], "", $rule[1]));
    $bagTree = new BagTree(str_replace([" bags", " bag", "."], "", $rule[0]));
    $rules[$rule[0]] = $bags;
}
if (key_exists($specBag, $rules)) {
    $specBagTree = new BagTree($specBag);
    insertChildren($specBagTree, $rules);
}


function insertChildren(&$bagTree, $rules)
{
    $rule = $rules[(string)$bagTree];

    foreach ($rule as $numberOfChild) {
        if (!str_contains($numberOfChild, "no other")) {
            $holder = [];
            preg_match("/[0-9]+/", $numberOfChild, $holder);
            $number = $holder[0];
            preg_match("/[a-z]+\s+[a-z]+/", $numberOfChild, $holder);
            $childName = $holder[0];
            $child = $bagTree->addChild($childName, $number);
            insertChildren($child, $rules);
        }
    }
}

$numBagsInBag = $specBagTree->getBagsInThis();
print($numBagsInBag);




