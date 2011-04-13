<?php
class Zftest_Validate_MwopTest extends PHPUnit_Framework_TestCase
{
    public function fullnameProvider()
    {
        return array (
            array ("Matthew Weier O'Phinney"),
            array ("D. Keith Casey, Jr."),
            array ("Jean-Claude Van Damme"),
            array ("C3PIO"),
        );
    }
    public function badnameProvider()
    {
        return array (
            array ("1' OR 1=1; --"),
            array ("\''; DROP TABLE users; --"),
        );
    }
    /**
     * @dataProvider fullnameProvider
     */
    public function testCorrectNamesPassMwopTest($fullname)
    {
        $mwop = new Prozf_Validate_Mwop();
        $this->assertTrue($mwop->isValid($fullname));
    }
    /**
     * @dataProvider badnameProvider
     */
    public function testBadNamesDoNotPassMwopTest($badname)
    {
        $mwop = new Prozf_Validate_Mwop();
        $this->assertFalse($mwop->isValid($badname));
    }
}