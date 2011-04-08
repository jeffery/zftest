<?php

class Application_Form_CommentForm extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'name', array (
        	'Label' => 'Name',
            'Required' => true,
            'Filters' => array (),
            'Validators' => array (),
        ));
        $this->addElement('text', 'mail', array (
        	'Label' => 'E-mail Address',
            'Required' => true,
            'Filters' => array (),
            'Validators' => array (),
        ));
        $this->addElement('text', 'web', array (
        	'Label' => 'Website',
            'Required' => false,
            'Filters' => array (),
            'Validators' => array (),
        ));
        $this->addElement('textarea', 'comment', array (
        	'Label' => 'Comment',
            'Required' => true,
            'Filters' => array (),
            'Validators' => array (),
        ));
        $this->addElement('submit', 'post', array (
        	'Label' => 'Post',
            'Ignore' => true,
        ));
    }


}

