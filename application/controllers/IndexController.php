<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_session = new Zend_Session_Namespace('commentForm');
    }

    public function indexAction()
    {
        $form = $this->_getForm();
        if (isset ($this->_session->commentForm)) {
            $form->populate(unserialize($this->_session->commentForm));
            unset ($this->_session->commentForm);
        }
        $this->view->form = $form;
        
        $commentMapper = new Application_Model_CommentMapper();
        $this->view->comments = $commentMapper->fetchAll();
    }

    public function processAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->_helper->redirector('index');
        }
        $form = $this->_getForm();
        
        if (!$form->isValid($this->getRequest()->getPost())) {
            $this->_session->commentForm = serialize($form);
            return $this->_helper->redirector('index');
        }
        $values = $form->getValues();
        $data = array (
            'fullName' => $values['name'],
            'emailAddress' => $values['mail'],
            'website' => $values['web'],
            'comment' => $values['comment'],
        );
        $commentMapper = new Application_Model_CommentMapper();
        $comment = new Application_Model_Comment($data);
        $commentMapper->save($comment);
        $this->_session->fullName = $comment->getFullName();
        return $this->_helper->redirector('success');
    }

    public function successAction()
    {
        if (!isset ($this->_session->fullName)) {
            return $this->_helper->redirector('index');
        }
        $this->view->fullName = $this->_session->fullName;
        unset ($this->_session->fullName);
    }
    
    protected function _getForm()
    {
        $form = new Application_Form_CommentForm(array (
            'method' => 'post',
            'action' => $this->view->url(array (
                'controller' => 'index',
                'action' => 'process',
            )),
            'id' => 'commentForm',
        ));
        return $form;
    }



}





