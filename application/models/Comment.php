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
 * Application_Model_Comment
 * 
 * Class that defines a data container for comment data coming from the
 * website (through a form), from the database, a web service or any other kind
 * of external storage/provider.
 * 
 * @author 		Michelangelo <dragonbe+github@gmail.com>
 * @package		Zftest
 * @category	Application_Model
 */
class Application_Model_Comment
{
    /**
     * @var 	int The sequence ID of this comment
     */
    protected $_id = 0;
    /**
     * @var 	string The full name of the comment submitter
     */
    protected $_fullName;
    /**
     * @var 	string The email address of the comment submitter
     */
    protected $_emailAddress;
    /**
     * @var 	string The website of the comment submitter
     */
    protected $_website;
    /**
     * @var 	string The comment itself
     */
    protected $_comment;
    /**
     * @var 	array List of filters for filtering incoming data
     */
    protected $_filters;
    /**
     * @var 	array List of validators for validating incoming data
     */
    protected $_validators;
    /**
     * Constructor for this comment class. It instantiates filters and
     * validators en populates this class with optionally provided data.
     * 
     * @param 	null|array|Zend_Db_Table_Row $params
     */
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
    /**
     * Sets the sequence ID for this comment
     * 
     * @param 	int $id
     * @return	Application_Model_Comment
     * @throws	Zend_Exception
     */
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
    /**
     * Retrieves the sequence ID from this comment
     * 
     * @return	int
     */
    public function getId()
    {
        return $this->_id;
    }
    /**
     * Sets the full name of the submitter for this comment
     * 
     * @param 	string $fullName
     * @return	Application_Model_Comment
     * @throws	Zend_Exception
     */
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
    /**
     * Retrieves the full name of the submitter from this comment
     * 
     * @return	string
     */
    public function getFullName()
    {
        return $this->_fullName;
    }
    /**
     * Sets the email address of the submitter for this comment
     * 
     * @param 	string $emailAddress
     * @return	Application_Model_Comment
     * @throws	Zend_Exception
     */
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
    /**
     * Retrieves the email address of the submitter from this comment
     * 
     * @return	string
     */
    public function getEmailAddress()
    {
        return $this->_emailAddress;
    }
    /**
     * Sets the website of the submitter for this comment
     * 
     * @param 	string $website
     * @return	Application_Model_Comment
     * @throws	Zend_Exception
     */
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
    /**
     * Retrieves the website of the submitter from this comment
     * 
     * @return	string
     */
    public function getWebsite()
    {
        return $this->_website;
    }
    /**
     * Sets the comment for this comment
     * 
     * @param 	string $comment
     * @return	Application_Model_Comment
     * @throws	Zend_Exception
     */
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
    /**
     * Retrieves the comment from this comment
     * 
     * @return	string
     */
    public function getComment()
    {
        return $this->_comment;
    }
    /**
     * Populates this comment class with data
     * 
     * @param 	array|Zend_Db_Table_Row $row
     */
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
    /**
     * Converts this comment into an array
     * 
     * @return	array
     */
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

