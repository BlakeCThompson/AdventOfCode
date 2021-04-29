<?php


/**
 * Class CorrespondingFinder
 *
 * finds numbers in a data set that sum to a given number, returning them with their indexes.
 */
class CorrespondingFinder
{
    private $data = [];
    private $corresponding = [];
    private $find;

    public function __construct(array $data, int $find)
    {
        $this->data = $data;
        $this->find = $find;
    }

    //starting from zero, search for any combination of numbers in the data set that sum to the broken element.

    /**
     * @param $indexes is the number of indexes being used to sum together the broken element.
     * @return array of index values taken from the data set whose corresponding values sum to the broken element.
     */
    public function findWith()
    {
        //for each index, we need to iterate completely through the array of data to get every combination.
        //so try summing every index of the data, move the furthest right (n) index right until it gets to the end
        $this->iterateThrough([0, 1], 1);
    }

    private function iterateThrough($indexes, $index)
    {

        //check if this combination sums to the broken piece.
        $sum = 0;
        foreach ($indexes as $i) {
            $sum += $this->data[$i];
        }
        if ($sum == $this->find) {
            return $indexes;
        }
        $key = array_search($index, $indexes);
        //if our index isn't at the end of the data set. (Remember, the value $index is the line number of the data)
        if ($index < count($this->data)) {

            //if our index is next to another index
            if ($index + 1 == $this->data[$indexes[$key + 1]]) {
                //iterate through for the next index
                $result = $this->iterateThrough($indexes, $index + 1);
                if ($result) {
                    return $result;
                }
            } //else we must be able to continue shuffling right
            else {
                $indexes[$key] = $index + 1;
                $this->iterateThrough($indexes, $index + 1);
            }
        } //if we are at the end of the data set, and this is not the first piece of data,
        //move the preceding index over one, and reset this index's value back to the value following the previous index's value.
        else if ($index != 0) {
            $indexes[$key - 1] +=1;
            $indexes[$key] = $indexes[$key - 1] + 2;
            $this->iterateThrough($indexes,$index-1);
        } else return false;
    }


}

$arr = [3, 5, 6, 7, 10];
$cf = new CorrespondingFinder($arr, 11);
print_r("result: " . $cf->findWith());