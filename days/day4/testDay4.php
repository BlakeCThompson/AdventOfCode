<?php

use PHPUnit\Framework\TestCase;

require_once "day4brunner.php";

class testDay4 extends TestCase
{
    public function testInvalids()
    {
        $invalidBatchesFile = "invalidPassports";
        $batchOpener = new BatchOpener();
        $valid = $batchOpener->getValidBatches($invalidBatchesFile);
        $this->assertTrue($valid ==0);
    }

    public function testSample()
    {
        $invalidBatchesFile = "Sample1";
        $batchOpener = new BatchOpener();
        $valid = $batchOpener->getValidBatches($invalidBatchesFile);
        $this->assertTrue($valid ==3);
    }

    public function testValidPassportId()
    {
        $pid = new PassPortId();
        $pid->setVal(556412378);
        $this->assertTrue($pid->isValid());
        //try too low
        $pid->setVal(55641232);
        $this->assertTrue(!$pid->isValid());
        //try too high
        $pid->setVal(5564122378);
        $this->assertFalse($pid->isValid());
    }

    public function byr()
    {
        $pid = new BirthYear();
        $pid->setVal(1920);
        $this->assertTrue($pid->isValid());
        //too low
        $pid->setVal(1919);
        $this->assertFalse($pid->isValid());
        //too high
        $pid->setVal(2003);
        $this->assertFalse($pid->isValid());
    }

    public function testHcl()
    {
        $pid = new HairColor();
        $pid->setVal("#232abc");
        $this->assertTrue($pid->isValid());
        //test no #
        $pid->setVal("232abc");
        $this->assertFalse($pid->isValid());
        //test no #, and short
        $pid->setVal("32abc");
        $this->assertFalse($pid->isValid());
        //test with #, but too short
        $pid->setVal("#231abab");
        $this->assertTrue($pid->isValid());
    }

    public function testEYR()
    {
        $eyr = new ExpirationYear();
        $eyr->setVal(2024);
        $this->assertTrue($eyr->isValid());
        //too high
        $eyr->setVal(2032);
        $this->assertFalse($eyr->isValid());
        //too low
        $eyr->setVal(2019);
        $this->assertFalse($eyr->isValid());
        //bad format
        $eyr->setVal("#32asda");
        $this->assertFalse($eyr->isValid());
    }

    public function testIYR()
    {
        $iyr = new IssueYear();
        $iyr->setVal(2011);
        $this->assertTrue($iyr->isValid());
        //too low
        $iyr->setVal(2009);
        $this->assertFalse($iyr->isValid());
        //too high
        $iyr->setVal(2021);
        $this->assertFalse($iyr->isValid());
    }

    public function testHGT()
    {
        //valid cases
        $eyr = new Height();
        $eyr->setVal("60in");
        $this->assertTrue($eyr->isValid());
        $eyr->setVal("150cm");
        $this->assertTrue($eyr->isValid());
        //invalid cases
        $eyr->setVal("60");
            //case where inches are too low
        $eyr->setVal("58in");
        $this->assertFalse($eyr->isValid());
            //inches too high
        $eyr->setVal("77in");
        $this->assertFalse($eyr->isValid());
        $eyr->setVal("60c");
            //cm too low
        $eyr->setVal("149cm");
        $this->assertFalse($eyr->isValid());
            //cm too high
        $eyr->setVal("194cm");
        $this->assertFalse($eyr->isValid());
            //no unit of measurement
        $eyr->setVal("123");
        $this->assertFalse($eyr->isValid());
    }

    public function testECL()
    {
        $eyr = new EyeColor();
        $eyr->setVal("blu");
        $this->assertTrue($eyr->isValid());
        //invalid
        $eyr->setVal("trq");
        $this->assertFalse($eyr->isValid());
    }
    public function blanks(){
        $byr = new BirthYear();
        assertFalse($byr->isValid());
        $iyr = new IssueYear();
        assertFalse($iyr->isValid());
        $hgt = new Height();
        assertFalse($hgt->isValid());
        $hcl = new HairColor();
        assertFalse($hcl->isValid());
        $ecl = new EyeColor();
        assertFalse($ecl->isValid());
        $pid = new PassportField();
        assertFalse($pid);
    }

    public function testReal()
    {
        $batchOpener = new BatchOpener();
        print($batchOpener->getValidBatches("batch"));
        $this->assertTrue(true);
    }
}
