<?php


class BagTree
{
    // a tree root will always branch from exactly one or 0 parents.
    //a tree can have 0 or many children.
    //a bag tree can have a number of duplicate children.
    private $root = "";
    private $number = 0;
    //children is a 2 dimensional array, with name of child root, followed by a value (default 1).
    private $children = [];

    public function __construct($root, $number = 0)
    {
        $this->root=$root;
        $this->number = $number;
    }

    public function addChild($childRoot, $num = 1)
    {
        $this->children[$childRoot] = new BagTree($childRoot, $num);
        return $this->children[$childRoot];
    }

    public function getNumberOfThisInParent(){
        return $this->number;
    }

    public function __toString()
    {
        return $this->root;
    }

    public function getBagsInThis()
    {
        $numBags = 0;
        if(count($this->children) > 0) {
            foreach ($this->children as $child) {
                $numBags += $child->getNumberOfThisInParent() * ($child->getBagsInThis()+1);//+1 is to count the actual child bag
            }
        }
        else{
            return 0;
        }
        print($this." has ".$numBags." in it.\n");
        return $numBags;
    }
}