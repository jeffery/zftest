<?php
class Zftest_Service_Joindin_Talk extends Zftest_Service_Joindin_Abstract
{
    const JOINDIN_API_END = '/talk';
    /**
     * @var 	Zftest_Service_Joindin
     */
    protected $_joindin;
    /**
     * Sets the joindin instance
     * 
     * @see 	Zftest_Service_Joindin_Abstract::setJoindin()
     * @param	Zftest_Service_Joindin
     * @return	Zftest_Service_Joindin_Event
     */
    public function setJoindin(Zftest_Service_Joindin $joindin)
    {
        $this->_joindin = $joindin;
        return $this;
    }
    /**
     * Retrieves the joindin instance
     * 
     * @see 	Zftest_Service_Joindin_Abstract::getJoindin()
     * @return	Zftest_Service_Joindin
     */
    public function getJoindin()
    {
        return $this->_joindin;
    }
}