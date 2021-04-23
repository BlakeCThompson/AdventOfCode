<?php

require_once "InsReader.php";
$instructionsFile = "instructions";
$instructionReader = new InsReader($instructionsFile);
$instructionReader->readInstructions();
$jumpLines = [];
for($i =0; $i<$instructionReader->numberInstructions();$i++){
    if(str_contains($instructionReader->getInstruction($i)[0],"jmp")){
        array_push($jumpLines,$i);
    }
}
foreach ($jumpLines as $jumpLine) {
    print("changing $jumpLine to nop");
    $instructions = $instructionReader->getInstructions();
    $instructions[$jumpLine] = array("nop","+0");
    $instructionReader->setInstructions($instructions);
    $instructionReader->readInstructions();
    $instructionReader = new $instructionReader($instructionsFile);
}