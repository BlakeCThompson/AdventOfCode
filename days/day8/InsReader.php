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
    public function numberInstructions(){
        return count($this->instructions);
}

    /**
     * @param array $instructions
     * set instruction set with an array of instructions in format [command]=>[value]
     */
    public function setInstructions(array $instructions): void
    {
        $this->instructions = $instructions;
    }

    /**
     * @return array
     * get array of instructions
     */
    public function getInstructions(): array
    {
        return $this->instructions;
    }
    public function getInstruction($lineNo){
        return $this->instructions[$lineNo];
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
    private function acc($lineNo,$accNumber,){
        $this->accumulator+=$accNumber;
        $this->move($lineNo+=1);
    }
    private function nop($lineNo,$ignored=""){
        $this->move($lineNo+1);
    }
    private function jmp($lineNo,$numLines,){
        $this->move($lineNo+$numLines);
    }

    private function move($newPos){
        if(in_array($newPos,$this->linesVisited)){
            $lastInstruction = array_pop($this->linesVisited);
            print("line ".$newPos." visited twice. previous line: ".$lastInstruction." ".print_r($this->instructions[$lastInstruction],true)."\naccumulator: ".$this->accumulator);
            throw new Exception();
        }
        if($newPos >= count($this->instructions)){
            print("\nend of instructions detected.\n");
            print("accumulator total: $this->accumulator");
            die();
            return 0;
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
            print("\ninfinite loop detected. Exiting.\n");

        }
    }


}