<?php
/**
 * Zftest
 * 
 * 
 * This source code is used as example code for presentations I give at several
 * PHP conferences around the world. You're free to use, build on-top of it and
 * share with others. You can find this source code on my public GitHub account
 * {@link https://github.com/DragonBe/zftest} where you can fork this code,
 * provide comments and feedback or just play with it.
 * 
 * @license		CreativeCommons-Attribution-ShareAlike
 * @link 		http://creativecommons.org/licenses/by-sa/3.0/
 * @package		Zftest
 */
/**
 * Application_Form_CommentForm
 * 
 * Provides a form object that allows users to pass comments from the website.
 * 
 * @author 		Michelangelo <dragonbe+github@gmail.com>
 * @category	Application_Form
 */
class Application_Form_CommentForm extends Zend_Form
{
    /**
     * Initializes this form
     * 
     * @see 	Zend_Form::init()
     */
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

