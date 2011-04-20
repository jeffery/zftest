<?php
class Zftest_Service_JoindinTest extends PHPUnit_Framework_TestCase
{
    protected $_joindin;
    protected $_settings;
    
    protected function setUp()
    {
        $this->_joindin = new Zftest_Service_Joindin();
        // using the test adapter for testing
        $client = new Zend_Http_Client();
        $client->setAdapter(new Zend_Http_Client_Adapter_Test());
        $this->_joindin->setClient($client);
        
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
        $response = <<<EOS
HTTP/1.1 200 OK
Content-type: text/xml

<?xml version="1.0"?>
<response>
  <item>
    <username>DragonBe</username>
    <full_name>Michelangelo van Dam</full_name>
    <ID>19</ID>
    <last_login>1303248639</last_login>
  </item>
</response>        
EOS;
        $client = $this->_joindin->getClient()->getAdapter()->setResponse($response);
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
        $response = <<<EOS
HTTP/1.1 200 OK
Content-type: text/xml

<?xml version="1.0"?>
<response>
  <dt>{$date->format('r')}</dt>
  <test_string>testing unit test</test_string>
</response>        
EOS;
        $client = $this->_joindin->getClient()->getAdapter()->setResponse($response);
        $expected = '<?xml version="1.0"?><response><dt>' . $date->format('r') . '</dt><test_string>testing unit test</test_string></response>';
        $actual = $this->_joindin->site()->getStatus('testing unit test');
        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }
}