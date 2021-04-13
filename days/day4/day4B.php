<?php

class Batch
{
    private $privateFields = [];

    public function __construct($raw)
    {

        $this->raw = $raw;
        $this->privateFields = [
            "byr" => new BirthYear(),
            "iyr" => new IssueYear(),
            "eyr" => new ExpirationYear(),
            "hgt" => new Height(),
            "hcl" => new HairColor(),
            "ecl" => new EyeColor(),
            "pid" => new PassportId()
        ];
        $this->assignFields();
    }

    public function batchIsValid()
    {
        $valid = 1;
        foreach ($this->privateFields as $privateField => $val) {
            if (!$val->isValid()) {
                return 0;
            }
        }
        return $valid;
    }

    public function assignFields()
    {
        if ($this->raw) {
            $batchFields = preg_split('/\s+/', $this->raw);
            $batchMap = [];
            foreach ($batchFields as $batchField) {
                try {
                    $keyval = explode(":", $batchField);
                    $batchMap[$keyval[0]] = $keyval[1];
                }catch(Exception $e){
                    print($e->getTraceAsString());
                }
            }
            foreach ($this->privateFields as $field => $value) {
                if (key_exists($field, $batchMap)) {
                    $value->setVal($batchMap[$field]);
                }
            }
        }
    }
}

class PassportField
{
    protected $val;

    public function __construct($val = "")
    {
        $this->val = $val;
    }

    public function getVal()
    {
        return $this->val;
    }

    public function setVal($val)
    {
        $this->val = $val;
    }

    public function isValid()
    {
        return 1;
    }

}

trait YearValue
{
    public function isValidYear($beginYear, $endYear, $year)
    {
        if ((int)$year >= (int)$beginYear && (int)$year <= (int)$endYear) {
            return true;
        } else return false;
    }
}

class BirthYear extends PassportField
{
    use YearValue;

    private $beginYear = 1920;
    private $endYear = 2002;

    public function isValid()
    {
        return $this->isValidYear($this->beginYear, $this->endYear, $this->val);
    }
}

class IssueYear extends PassportField
{
    use YearValue;

    private $beginYear = 2010;
    private $endYear = 2020;

    public function isValid()
    {
        return $this->isValidYear($this->beginYear, $this->endYear, $this->val);
    }
}

class ExpirationYear extends PassportField
{
    use YearValue;

    private $beginYear = 2020;
    private $endYear = 2030;

    public function isValid()
    {
        return $this->isValidYear($this->beginYear, $this->endYear, $this->val);
    }
}

class Height extends PassportField
{
    public function isValid()
    {
        if(preg_match("/[0-9]+((in)|(cm))$/i", $this->val) > 0) {
            if (preg_match("/(cm)$/i", $this->val) > 0) {
                $cms =[];
                preg_match("/^[0-9]+/", $this->val,$cms);
                return ($cms[0] >= 150 && $cms[0] <= 193);
            }
            else if(preg_match("/(in)$/i", $this->val) > 0){
                $inches =[];
                preg_match("/^[0-9]+/",$this->val,$inches);
                return ($inches[0] >= 59 && $inches[0] <=76);
            }
        }
        else return false;
    }
}

class HairColor extends PassportField
{
    public function isValid()
    {
        if (preg_match("/#[0-9|A-F]{6}/i", $this->val) > 0) {
            return true;
        } else {
            return false;
        }
    }
}

class EyeColor extends PassportField
{
    public function isValid()
    {
        return in_array($this->val, ["amb", "blu", "brn", "gry", "grn", "hzl", "oth"]);
    }
}

class PassportId extends PassportField
{
    public function isValid()
    {
        if (preg_match("/^[0-9]{9}$/", $this->val) > 0) {
            return true;
        } else {
            return false;
        }
    }
}