<?php
require_once "day4B.php";

class BatchOpener{
    private $batchFileName;
    private $batchesArr= [];
    public function getValidBatches($batchFileName){
        $batchFile = fopen($batchFileName, "r") or die("Unable to open file!");
        $allRawBatches = file_get_contents($batchFileName);
        $batches = explode(PHP_EOL . PHP_EOL, $allRawBatches);
        $batchesArr = [];
        foreach ($batches as $batch) {
            array_push($batchesArr, new Batch(trim($batch)));
        }

        $numValid = 0;
        foreach ($batchesArr as $batch) {
            if ($batch->batchIsValid() == 1) {
                $numValid += 1;
            }
            else{$test ="";}
        }
        return $numValid;
    }
}
