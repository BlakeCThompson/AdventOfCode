<?php
$rulesFile = "sampleAnswers";
$rawRules = file_get_contents($rulesFile);
$ruleLines = explode(PHP_EOL, $rawRules);
$searchedFor = "shiny gold";
$eventuallyHoldsGold = [];
includesBag($ruleLines, $searchedFor, $eventuallyHoldsGold);
unset($eventuallyHoldsGold[$searchedFor]);

while (array_search(0, $eventuallyHoldsGold) != false) {
    $unsearchedArray = array_keys($eventuallyHoldsGold, 0);
    foreach ($unsearchedArray as $unsearched) {
        includesBag($ruleLines, $unsearched, $eventuallyHoldsGold);
    }
}

function includesBag($ruleLines, $searchedFor, &$eventuallyHoldsBag)
{
    foreach ($ruleLines as $ruleLine) {
        $rule = explode("contain", $ruleLine);
        if (str_contains($rule[1], $searchedFor)) {
            $eventuallyHoldsBag[str_replace([" bags", " bag"], "", $rule[0])] = 0;
        }
    }
    $eventuallyHoldsBag[$searchedFor] = 1;
}


//print_r($eventuallyHoldsGold);
print("bags that eventually hold ".$searchedFor.": ".count($eventuallyHoldsGold)."\n");
$bagEventuallyHolds = [];
$bag = $searchedFor;
$count = 0;

bagIncludes($ruleLines, $bag, $bagEventuallyHolds);
foreach ($bagEventuallyHolds as $bagHolds){
    $count+=$bagHolds;
}

print_r($bagEventuallyHolds);
print("bags that ".$searchedFor." eventually holds: ".$count."\n");
//note: regex for things that contain exactly one type of bag: "/contain (([0-9])( [a-z|\s]+(\.)))/"
function bagIncludes($ruleLines, $bag, &$bagEventuallyHolds)
{
    foreach ($ruleLines as $ruleLine) {
        $rule = explode("contain", $ruleLine);
        if (str_contains($rule[0], $bag)) {
            //get every bag within this bag, and add it to the list of bags within parent.
            $bags = explode(",", str_replace([" bags", " bag","."], "", $rule[1]));
            //$bagEventuallyHolds[str_replace([" bag"," bags"],"",$rule[1])] = 0;
            foreach ($bags as $bag) {
                $numberOfBag = [];
                preg_match("/[0-9]+/", $bag, $numberOfBag);
                if (count($numberOfBag) > 0) {
                    $bag = str_replace(" " . $numberOfBag[0] . " ", "", $bag);
                    if(array_key_exists($bag, $bagEventuallyHolds)) {
                        $bagEventuallyHolds[$bag] += $numberOfBag[0];
                    }
                    else{
                        $bagEventuallyHolds[$bag] = $numberOfBag[0];
                    }
                    if (!str_contains($bag, "no other bags")) {
                        bagIncludes($ruleLines, $bag, $bagEventuallyHolds[$bag]);
                    }
                }
            }
        }
    }
}




