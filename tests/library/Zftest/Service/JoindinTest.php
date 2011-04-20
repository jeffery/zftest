<?php
class Zftest_Service_JoindinTest extends PHPUnit_Framework_TestCase
{
    protected $_joindin;
    protected $_settings;
    
    protected function setUp()
    {
        $this->_joindin = new Zftest_Service_Joindin();
        $settings = simplexml_load_file(realpath(
            APPLICATION_PATH . '/../tests/_files/settings.xml'));
        $this->_settings = $settings->joindin;
        parent::setUp();
    }
    protected function tearDown()
    {
        parent::tearDown();
        $this->_joindin = null;
    }
    public function testJoindinCanGetUserDetails()
    {
        $expected = '<?xml version="1.0"?><response><item><username>DragonBe</username><full_name>Michelangelo van Dam</full_name><ID>19</ID><last_login>1303248639</last_login></item></response>';
        $this->_joindin->setUsername($this->_settings->username)
                       ->setPassword($this->_settings->password);
        $actual = $this->_joindin->user()->getDetail();
        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }
    public function testJoindinCanCheckStatus()
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('UTC'));
        $expected = '<?xml version="1.0"?><response><dt>' . $date->format('r') . '</dt><test_string>testing unit test</test_string></response>';
        $actual = $this->_joindin->site()->getStatus('testing unit test');
        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }
}