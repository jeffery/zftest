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
 * Zftest_Validate_TextBox
 * 
 * Validates comments so people can submit all kinds of comments, even have it
 * emphasized using bold <b> and italic <i> tags.
 * 
 * @author 		Michelangelo <dragonbe+github@gmail.com>
 * @category	Zftest_Validate
 */
class Zftest_Validate_TextBox extends Zend_Validate_Abstract
{
    const MSG_INVALID_SIZE = 'invalidSize';
    const MSG_INVALID_TXT = 'invalidTxt';
    
    /**
     * @var 	int The maximum limit of the textsize
     */
    public $max;
    
    /**
     * @var 	array Variables used in the error messages
     */
    protected $_messageVariables = array (
        self::MSG_INVALID_SIZE => 'max',
    );
    /**
     * @var 	array Error messages used by this validator
     */
    protected $_messageTemplates = array (
        self::MSG_INVALID_SIZE => '%value% exceeds %max% size limit',
        self::MSG_INVALID_TXT => '%value% is not valid text',
    );
    /**
     * Constructor for this validation class
     * 
     * @param 	int $max
     */
    public function __construct($max = 5000)
    {
        $this->max = (int) $max;
    }
    /**
     * Validates the provided text if it matches predefined conditions and 
     * returns TRUE if the text is valid, or returns FALSE if the text doesn't
     * match the conditions.
     * 
     * @param	string $value
     * @return	boolean
     * @see 	Zend_Validate_Interface::isValid()
     */
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