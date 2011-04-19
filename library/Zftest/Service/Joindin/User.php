<?php
class Zftest_Service_Joindin_User extends Zftest_Service_Joindin_Abstract
{
    const JOINDIN_API_END = '/user';
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
     * @throws	Zftest_Service_Joindin_Exception
     */
    public function getJoindin()
    {
        if (null === $this->_joindin || !$this->_joindin instanceof Zftest_Service_Joindin) {
            throw new Zftest_Service_Joindin_Exception('Joindin instance not set yet');
        }
        return $this->_joindin;
    }
    public function getDetail()
    {
        if (null === $this->getJoindin()->getUsername()) {
            throw new Zftest_Service_Joindin_Exception('Required username missing');
        }
        if (null === $this->getJoindin()->getPassword()) {
            throw new Zftest_Service_Joindin_Exception('Required password missing');
        }
        $detail = $this->getJoindin()
                       ->getMessage()
                       ->addChild('action');
        $detail->addAttribute('type', 'getdetail');
        $detail->addAttribute('output', $this->getJoindin()->getOutput());
        $detail->addChild('uid', $this->getJoindin()->getUsername());
        $response = $this->getJoindin()->connect(
            $this->getJoindin()->getMessage(), self::JOINDIN_API_END);
        if ($response->isError()) {
            throw new Zftest_Service_Joindin_Exception($response->getMessage());
        }
        return $response->getBody();
    }
}