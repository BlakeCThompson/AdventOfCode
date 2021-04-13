<?php

$batchFilename = "./batch";

$batchFile = fopen($batchFilename, "r") or die("Unable to open file!");
$test = fgets($batchFile);
$allRawBatches = file_get_contents($batchFilename);
$batches = explode(PHP_EOL . PHP_EOL, $allRawBatches);
$batchesArr=[];
foreach ($batches as $batch){
    array_push($batchesArr, new Batch($batch));
}

$numValid = 0;
foreach($batchesArr as $batch){
        if($batch->isValid() ==1){
            $numValid+=1;
        }
}

echo($numValid);

class Batch
{
    private $privateFields = [
        "byr" =>"",
        "iyr" =>"",
        "eyr" =>"",
        "hgt" =>"",
        "hcl" =>"",
        "ecl" =>"",
        "pid" =>"",
        "cid" =>""
    ];

    public function __construct($raw)
    {
        $this->raw = $raw;
        $this->assignFields();
    }
    public function isValid(){
        $valid = 1;
        foreach($this->privateFields as $privateField=>$val){
            if($privateField !=="cid" && $val == ""){
                $valid = 0;
            }
        }
        return $valid;
    }
    public function assignFields()
    {
        if ($this->raw) {
            $batchFields = preg_split('/\s+/', $this->raw);
            $batchMap = [];
            foreach($batchFields as $batchField){
                $keyval = explode(":",$batchField);
                $batchMap[$keyval[0]]=$keyval[1];
            }
            foreach ($this->privateFields as $field=>$value) {
                $this->privateFields[$field] = $batchMap[$field];
            }
        }
    }
}
