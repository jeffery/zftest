<?php
/**
 * Application_Model_User
 * 
 * Contains the minimum requirements to identify a specific user to the system.
 * 
 * @category	Prozf
 * @package		Application_Model
 *
 */
class Prozf_Validate_PasswordStrength extends Zend_Validate_Abstract
{
    const PASSWD_WEAK = 'weak';
    const PASSWD_MEDIUM = 'medium';
    const PASSWD_STRONG = 'strong';
    
    /**
     * @var 	string The strength of the password
     */
    public $strength = null;
    
    /**
     * @var 	string The error message templates to indicate mistakes
     */
    protected $messageTemplates = array (
        self::PASSWD_WEAK => "'%value%' is too easy and not acceptable",
        self::PASSWD_MEDIUM => "'%value% is too weak to meet our medium standards",
        self::PASSWD_STRONG => "'%value% is not strong enough",
    );
    /**
     * Constructor for this validator allowing to set the minimal strength
     * level (weak, medium or strong)
     * 
     * @param 	string $strength
     */
    public function __construct($strength = null)
    {
        if (null !== $strength) {
            $this->strength = $strength;
        } else {
            $this->strength = self::PASSWD_WEAK;
        }
    }
    /**
     * Method to check if this password meets the minimum requirements and
     * returns TRUE if it meets the minimum requirements or FALSE if not.
     * 
     * @see 	Zend_Validate_Interface::isValid()
     * @param	string $password The password you want to validate
     * @return	boolean
     */
    public function isValid($password)
    {
        $this->_setValue($password);
        
        switch ($this->strength) {
            case self::PASSWD_WEAK:
                if (6 > strlen($password)) {
                    $this->_error(self::PASSWD_WEAK);
                    return false;
                }
                break;
            case self::PASSWD_MEDIUM:
                if (8 > strlen($password) 
                    || 0 === preg_match('/[A-Z]/', $password) 
                    || 0 === preg_match('/[0-9]/', $password)) {
                    $this->_error(self::PASSWD_MEDIUM);
                    return false;
                }
                break;
            case self::PASSWD_STRONG:
                // @todo: Create a function to check if it's really as strong
                //        password
                if (10 > strlen($password)
                    || 0 === preg_match('/[A-Z]/', $password) 
                    || 0 === preg_match('/[0-9]/', $password)) {
                    $this->_error(self::PASSWD_MEDIUM);
                    return false;
                }
                break;
            default:
                break;
        }
        return true;
    }
}