<?php


class SeatDecoder
{

    public static function decodeSeat($binarySeatStr)
    {
        $bits = str_split($binarySeatStr);
        //these are actually 0 based, but for our calculations, we will make them look like 1 based first.
        $rowTop = 128;
        $rowBottom = 0;
        $colTop = 8;
        $colBottom = 0;
        foreach ($bits as $bit) {
            if (strcasecmp($bit, "F") == 0) {
                $rowTop = $rowTop - ($rowTop - $rowBottom) / 2;
            } else if (strcasecmp($bit, "B") == 0) {
                $rowBottom = $rowBottom + ($rowTop - $rowBottom) / 2;
            } else if (strcasecmp($bit, "L") == 0) {
                $colTop = $colTop - ($colTop - $colBottom) / 2;
            } else if (strcasecmp($bit, "R") == 0) {
                $colBottom = $colBottom + ($colTop - $colBottom) / 2;
            }
        }
        //top and bottom should be the same by the end here.
        return [$rowTop - 1, $colTop - 1];
    }

    public static function getId($rowCol)
    {
        return $rowCol[0] * 8 + $rowCol[1];
    }
}

class SeatsExtractor
{
    public static function extractSeats($seatFilename)
    {
        $allSeats = file_get_contents($seatFilename);
        return explode(PHP_EOL, $allSeats);
    }

    public static function getHighestId($seatFileName)
    {
        $allSeats = self::extractSeats($seatFileName);
        $highestId = 0;
        foreach ($allSeats as $seat) {
            $rowCol = SeatDecoder::decodeSeat($seat);
            if (($thisId = SeatDecoder::getId($rowCol)) > $highestId) {
                $highestId = $thisId;
            }
        }
        return $highestId;
    }
    public static function getAllIds($seatFileName){
        $allSeats = self::extractSeats($seatFileName);
        $ids = [];
        foreach ($allSeats as $seat) {
            $rowCol = SeatDecoder::decodeSeat($seat);
            array_push($ids,SeatDecoder::getId($rowCol));
        }
        sort($ids);
        return $ids;
    }
}