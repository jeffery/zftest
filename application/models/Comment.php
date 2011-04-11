<?php

class Application_Model_Comment
{
    protected $_id = 0;
    protected $_fullName;
    protected $_emailAddress;
    protected $_website;
    protected $_comment;
    protected $_filters;
    protected $_validators;
    
    public function __construct($params = null)
    {
        $this->_filters = array (
            'id' => array ('Int'),
            'fullName' => array ('StringTrim', 'StripTags'),
            'emailAddress' => array ('StringTrim', 'StripTags', 'StringToLower'),
            'website' => array ('StringTrim', 'StripTags', 'StringToLower'),
        	'comment' => array ('StringTrim', 'StripTags'),
        );
        $this->_validators = array (
            'id' => array ('Int'),
            'fullName' => array (
                new Zftest_Validate_Mwop(),
                new Zend_Validate_StringLength(array ('min' => 4, 'max' => 50)),
            ),
            'emailAddress' => array (
                'EmailAddress',
                new Zend_Validate_StringLength(array ('min' => 4, 'max' => 50)),
            ),
            'website' => array (
                new Zend_Validate_Callback(array('Zend_Uri', 'check')),
                new Zend_Validate_StringLength(array ('min' => 4, 'max' => 50)),
            ),
        	'comment' => array (
                new Zftest_Validate_TextBox(),
                new Zend_Validate_StringLength(array ('max' => 5000)),
            ),
        );
        if (null !== $params) {
            $this->populate($params);
        }
    }
    public function setId($id)
    {
        $input = new Zend_Filter_Input($this->_filters, $this->_validators);
        $input->setData(array ('id' => $id));
        if (!$input->isValid('id')) {
            throw new Zend_Exception('Invalid ID provided');
        }
        $this->_id = (int) $input->id;
        return $this;
    }
    public function getId()
    {
        return $this->_id;
    }
    public function setFullName($fullName)
    {
        $input = new Zend_Filter_Input($this->_filters, $this->_validators);
        $input->setData(array ('fullName' => $fullName));
        if (!$input->isValid('fullName')) {
            throw new Zend_Exception('Invalid fullName provided');
        }
        $this->_fullName = (string) $input->fullName;
        return $this;
    }
    public function getFullName()
    {
        return $this->_fullName;
    }
    public function setEmailAddress($emailAddress)
    {
        $input = new Zend_Filter_Input($this->_filters, $this->_validators);
        $input->setData(array ('emailAddress' => $emailAddress));
        if (!$input->isValid('emailAddress')) {
            throw new Zend_Exception('Invalid emailAddress provided');
        }
        $this->_emailAddress = (string) $input->emailAddress;
        return $this;
    }
    public function getEmailAddress()
    {
        return $this->_emailAddress;
    }
    public function setWebsite($website)
    {
        $input = new Zend_Filter_Input($this->_filters, $this->_validators);
        $input->setData(array ('website' => $website));
        if (!$input->isValid('website')) {
            throw new Zend_Exception('Invalid website provided');
        }
        $this->_website = (string) $input->website;
        return $this;
    }
    public function getWebsite()
    {
        return $this->_website;
    }
    public function setComment($comment)
    {
        $input = new Zend_Filter_Input($this->_filters, $this->_validators);
        $input->setData(array ('comment' => $comment));
        if (!$input->isValid('comment')) {
            throw new Zend_Exception('Invalid comment provided');
        }
        $this->_comment = (string) $input->comment;
        return $this;
    }
    public function getComment()
    {
        return $this->_comment;
    }
    public function populate($row)
    {
        if (is_array($row)) {
            $row = new ArrayObject($row, ArrayObject::ARRAY_AS_PROPS);
        }
        if (isset ($row->id)) $this->setId($row->id);
        if (isset ($row->fullName)) $this->setFullName($row->fullName);
        if (isset ($row->emailAddress)) $this->setEmailAddress($row->emailAddress);
        if (isset ($row->website)) $this->setWebsite($row->website);
        if (isset ($row->comment)) $this->setComment($row->comment);
    }
    public function toArray()
    {
        return array (
            'id'           => $this->getId(),
            'fullName'     => $this->getFullName(),
            'emailAddress' => $this->getEmailAddress(),
            'website'      => $this->getWebsite(),
            'comment'      => $this->getComment(),
        );
    }
}

