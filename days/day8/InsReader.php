<?php


class InsReader
{
    private $accumulator;
    private $linesVisited = [];
    private $instructions = [];
    private $currentLine = 0;
    public function __construct($fileName)
    {
        $this->makeInstrArray($fileName);
    }

    private function makeInstrArray($filename){
        $tempInstructions = file_get_contents($filename);
        $tempInstructions = explode(PHP_EOL,$tempInstructions);
        $instructions = [];
        $i=0;
        foreach ($tempInstructions as $instruction) {
            $instruction = explode(" ",$instruction);
            $instructions[$i]=$instruction;
            $i++;
        }
        $this->instructions = $instructions;

    }
    public function acc($lineNo,$accNumber,){
        $this->accumulator+=$accNumber;
        $this->move($lineNo+=1);
    }
    public function nop($lineNo,$ignored=""){
        $this->move($lineNo+1);
    }
    public function jmp($lineNo,$numLines,){
        $this->move($lineNo+$numLines);
    }

    public function move($newPos){
        if(in_array($newPos,$this->linesVisited)){
            $lastInstruction = array_pop($this->linesVisited);
            die("line ".$newPos." visited twice. previous line: ".$lastInstruction." ".print_r($this->instructions[$lastInstruction],true)."\naccumulator: ".$this->accumulator);
        }
        $this->currentLine = $newPos;
        array_push($this->linesVisited,$newPos);
    }
    public function readInstructions(){
        try {
            while (true) {
                $instr = $this->instructions[$this->currentLine][0];
                $val = $this->instructions[$this->currentLine][1];
                $this->$instr($this->currentLine, $val);
            }
        }catch(Exception $e){
            print($e->getTraceAsString());
        }
    }


}