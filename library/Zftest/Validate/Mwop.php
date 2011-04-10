<?php
class Zftest_Validate_Mwop extends Zend_Validate_Abstract
{
    const MWOP = 'mwop';
    
    protected $messageTemplates = array (
        self::MWOP => "'%value%' is not MWOP proof",
    );
    
    public function isValid($fullname)
    {
        $this->_setValue($fullname);
        
        $check = preg_match('([\"\=\*\;\[\]\#\\\?]+)', $fullname);
        if (1 === $check) {
            $this->_error(self::MWOP, $fullname);
            return false;
        }
        return true;
    }
}