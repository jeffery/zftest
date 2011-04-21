<?php

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(
            APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testIndexAction()
    {
        $params = array('action' => 'index', 'controller' => 'index', 'module' => 'default');
        $url = $this->url($this->urlizeOptions($params));
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($params['module']);
        $this->assertController($params['controller']);
        $this->assertAction($params['action']);
        $this->assertQueryContentContains('h1#pageTitle', 'Please leave a comment');
        $this->assertQueryCount('form#commentForm', 1);
    }

    public function testProcessAction()
    {
        $testData = array (
            'name'    => 'testUser',
            'mail'    => 'test@example.com',
            'web'     => 'http://www.example.com',
            'comment' => 'This is a test comment',
        );
        $params = array('action' => 'process', 'controller' => 'index', 'module' => 'default');
        $url = $this->url($this->urlizeOptions($params));
        $this->request->setMethod('post');
        $this->request->setPost($testData);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($params['module']);
        $this->assertController($params['controller']);
        $this->assertAction($params['action']);
        
        $this->assertResponseCode(302);
        $this->assertRedirectTo('/index/success');
        
        $this->resetRequest();
        $this->resetResponse();
        $this->dispatch('/index/success');
        $this->assertQueryContentContains('span#fullName', $testData['name']);
    }

    public function testSuccessAction()
    {
        $params = array('action' => 'success', 'controller' => 'index', 'module' => 'default');
        $url = $this->url($this->urlizeOptions($params));
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($params['module']);
        $this->assertController($params['controller']);
        $this->assertAction($params['action']);
        
        $this->assertRedirectTo('/');
    }


}







