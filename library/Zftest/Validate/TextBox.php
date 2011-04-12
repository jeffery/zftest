<?php
class Zftest_Validate_TextBox extends Zend_Validate_Abstract
{
    const MSG_INVALID_SIZE = 'invalidSize';
    const MSG_INVALID_TXT = 'invalidTxt';
    
    public $max;
    
    protected $_messageVariables = array (
        self::MSG_INVALID_SIZE => 'max',
    );
    
    protected $_messageTemplates = array (
        self::MSG_INVALID_SIZE => '%value% exceeds %max% size limit',
        self::MSG_INVALID_TXT => '%value% is not valid text',
    );
    
    public function __construct($max = 5000)
    {
        $this->max = (int) $max;
    }
    
    public function isValid($value)
    {
        $this->_setValue($value);
        
        if ($this->max < strlen($value)) {
            $this->_error(self::MSG_INVALID_SIZE);
            return false;
        }
        
        $regex = '/([a-zA-Z0-9\s\-\_\'\"\.\[\]\{\}\#\!\?\:\;\,\*\/\n<?\/b|i>]+)/';
        $test = preg_match($regex, $value, $match);
        if (isset ($match[1]) && 0 === strcmp($value, $match[1])) {
            return true;
        }
        $this->_error(self::MSG_INVALID_TXT);
        return false;
    }
}