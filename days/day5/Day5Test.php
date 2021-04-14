<?php


require_once "SeatDecoder.php";

use PHPUnit\Framework\TestCase;

class Day5Test extends TestCase
{

    public function testBaseTest()
    {
        print("TEST \n\n");
        $seatDecoder = new SeatDecoder();
        $rowCol = $seatDecoder->decodeSeat("BFFFBBFRRR");
        $seatId = $seatDecoder->getId($rowCol);
        $this->assertTrue($rowCol == [70, 7]);
        $this->assertTrue($seatId == 567);
        $rowCol = $seatDecoder->decodeSeat("FBFBBFFRLR");
        $this->assertTrue($rowCol == [44, 5]);
        $seatId = $seatDecoder->getId($rowCol);
        $this->assertTrue($seatId == 357);
        $rowCol = $seatDecoder->decodeSeat("FFFBBBFRRR");
        $this->assertTrue($rowCol == [14, 7]);
        $rowCol = $seatDecoder->decodeSeat("BBFFBBFRLL");
        $seatId = $seatDecoder->getId($rowCol);
        $this->assertTrue($seatId == 820);
        $this->assertTrue($rowCol == [102, 4]);
    }
    public function testExtractor(){
        $seatFile = "smallSeatingCodes";
        $seatExtractor = new SeatsExtractor();
        $seats = $seatExtractor->extractSeats($seatFile);
        $this->assertEquals(count($seats),3);
        $this->assertEquals(820, SeatsExtractor::getHighestId($seatFile));
    }
    public function testTotal(){
        $seatFile = "seatingCodes";
        print(SeatsExtractor::getHighestId($seatFile));
        $this->assertEquals(820, 820);
        $ids = SeatsExtractor::getAllIds($seatFile);
        //print_r($ids);
        for($i=0; $i < count($ids)-1; $i++){
            if($ids[$i] + 1 !=$ids[$i+1]){
                print("skipped value = ".$ids[$i]+1);
            }
        }
    }

}