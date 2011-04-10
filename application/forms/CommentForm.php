<?php

class Application_Form_CommentForm extends Zend_Form
{

    public function init()
    {
        $this->addElement('text', 'name', array (
        	'Label' => 'Name',
            'Required' => true,
            'Filters' => array ('StringTrim', 'StripTags'),
            'Validators' => array (
                new Zftest_Validate_Mwop(),
                new Zend_Validate_StringLength(array ('min' => 4, 'max' => 50)),
            ),
        ));
        $this->addElement('text', 'mail', array (
        	'Label' => 'E-mail Address',
            'Required' => true,
            'Filters' => array ('StringTrim', 'StripTags', 'StringToLower'),
            'Validators' => array (
                new Zend_Validate_EmailAddress(),
                new Zend_Validate_StringLength(array ('min' => 4, 'max' => 50)),
            ),
        ));
        $this->addElement('text', 'web', array (
        	'Label' => 'Website',
            'Required' => false,
            'Filters' => array ('StringTrim', 'StripTags', 'StringToLower'),
            'Validators' => array (
                new Zend_Validate_Callback(array('Zend_Uri', 'check')),
                new Zend_Validate_StringLength(array ('min' => 4, 'max' => 50)),
            ),
        ));
        $this->addElement('textarea', 'comment', array (
        	'Label' => 'Comment',
            'Required' => true,
            'Filters' => array ('StringTrim', 'StripTags'),
            'Validators' => array (
                new Zftest_Validate_TextBox(),
                new Zend_Validate_StringLength(array ('max' => 5000)),
            ),
        ));
        $this->addElement('submit', 'post', array (
        	'Label' => 'Post',
            'Ignore' => true,
        ));
    }


}

