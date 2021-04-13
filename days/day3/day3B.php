<?php


class HillTraverser {

private $hillMap;
private $rightPerTransition = 3;
private $downPerTransition = 1;

    public function __construct($mapFile, $rightPerTransition, $downPerTransition)
    {
        $this->rightPerTransition = $rightPerTransition;
        $downPerTransition = 1;
        $this->hillMap = $mapFile;
    }
    public function changeRightDownTransitions($newRightPerTransition,$newDownPerTransition =1){
        $this->rightPerTransition = $newRightPerTransition;
        $this->downPerTransition = $newDownPerTransition;
    }

    public function traverseHill(){
        $tobagganPosition = 0;
        $treesEncountered = 0;
        $hillMap = $this->hillMap;
        $downPerTransition = $this->downPerTransition;
        $rightPerTransition = $this->rightPerTransition;
        $hillMap = fopen($hillMap, "r") or die("Unable to open file!");
//find number of lines that follow a preceding rule.
        $currentLine = fgets($hillMap);
        while (!feof($hillMap)) {
            for ($i = 0; $i < $downPerTransition; $i++) {
                if (!$currentLine = fgets($hillMap)) {
                    print($treesEncountered."\n");
                    return $treesEncountered;
                }
            }

            if(substr($currentLine,-1)!="\n"){
                $tobagganPosition = ($tobagganPosition + $rightPerTransition) % count(str_split($currentLine));
            }
            else {
                //the position moves three to the right on every row. If we reach the end of the line, the position resets.
                //We decrease the count of the line by two, because every row is appended with newline characters \r,\n
                $tobagganPosition = ($tobagganPosition + $rightPerTransition) % (count(str_split($currentLine)) - 2);
            }

            $currentPosition = str_split($currentLine)[$tobagganPosition];
            //echo($row . " " . $tobagganPosition . " " . $currentPosition . "\n");
            if ($currentPosition == "#") {
               // print("Hit at ".$tobagganPosition."\n");
                $treesEncountered++;
            }
            else{
                //print("miss at ".$tobagganPosition."\n");
            }
}
        print($treesEncountered."\n");
        return($treesEncountered);
}
}

$productOfTreesHit = 1;
print("\n1,1 test\n");
$hillTraverser = new HillTraverser("tobogganHill",1,1);
$productOfTreesHit*=$hillTraverser->traverseHill();
print("\n3,1 test\n");
$hillTraverser->changeRightDownTransitions(3);
$productOfTreesHit*=$hillTraverser->traverseHill();
print("\n5,1 test\n");
$hillTraverser->changeRightDownTransitions(5);
$productOfTreesHit*=$hillTraverser->traverseHill();
print("\n7,1 test\n");
$hillTraverser->changeRightDownTransitions(7);
$productOfTreesHit*=$hillTraverser->traverseHill();
print("\n1,2 test: \n");
$hillTraverser->changeRightDownTransitions(1,2);
$productOfTreesHit*=$hillTraverser->traverseHill();

print("\n".$productOfTreesHit."\n");