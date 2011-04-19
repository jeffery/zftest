<?php
abstract class Zftest_Service_Joindin_Abstract
{
    /**
     * Sets the joindin instance
     * 
     * @param 	Zftest_Service_Joindin $joindin
     * @return	Zftest_Service_Joindin_Abstract
     */
    abstract public function setJoindin(Zftest_Service_Joindin $joindin);
    /**
     * Retrieves the joindin instance
     * 
     * @return	Zftest_Service_Joindin
     */
    abstract public function getJoindin();
}