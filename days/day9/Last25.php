<?php

class Last25
{
    private $twentyfive = [];

    public function __construct($elements)
    {
        if (count($elements) == 25) {
            foreach ($elements as $element) {
                array_push($this->twentyfive, $element);
            }
        }

    }

    public function array_push($element)
    {
        if ($this->checkIfValid($element)) {
            array_splice($this->twentyfive,0,1);
            array_push($this->twentyfive, $element);
        } else {
            print("$element is not valid.\n");
            throw new ErrorException("Bad input");
        }
    }

    private function checkIfValid($element)
    {
        $isValid = false;
        foreach ($this->twentyfive as $entry) {
            foreach ($this->twentyfive as $comparingEntry) {
                if ($entry != $comparingEntry) {
                    $sum = $entry + $comparingEntry;
                    if ($sum == $element) {
                        return true;
                    }
                }
            }
        }
        return $isValid;
    }
}