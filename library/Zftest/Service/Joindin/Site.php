<?php
class Zftest_Service_Joindin_Site extends Zftest_Service_Joindin_Abstract
{
    const JOINDIN_API_END = '/site';
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
    /**
     * Call the joindin status RPC
     * 
     * @param 	null|string $test
     * @return	string
     */
    public function getStatus($test = null)
    {
        $status = $this->getJoindin()
                       ->getMessage()
                       ->addChild('action');
        $status->addAttribute('type', 'status');
        $status->addAttribute('output', $this->getJoindin()->getOutput());
        if (null !== $test) {
            $status->addChild('test_string', $test);
        }
        
        $response = $this->getJoindin()->connect(
            $this->getJoindin()->getMessage(), self::JOINDIN_API_END);
        if ($response->isError()) {
            throw new Zftest_Service_Joindin_Exception($response->getMessage());
        }
        return $response->getBody();
    }
}