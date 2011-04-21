<?php
class Zftest_Service_Joindin_Event extends Zftest_Service_Joindin_Abstract
{
    const JOINDIN_API_END = '/event';
    const LISTING_HOT = 'hot';
    const LISTING_UPCOMING = 'upcoming';
    const LISTING_PAST = 'past';
    
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
    public function getListing($type = self::LISTING_HOT, $count = null)
    {
        $listing = $this->getJoindin()
                        ->getMessage()
                        ->addChild('action');
        $listing->addAttribute('type', 'getlist');
        $listing->addAttribute('output', $this->getJoindin()->getOutput());
        $listing->addChild('event_type', $type);

        $response = $this->getJoindin()->connect(
            $this->getJoindin()->getMessage(), self::JOINDIN_API_END);
        if ($response->isError()) {
            throw new Zftest_Service_Joindin_Exception($response->getMessage());
        }
        return $response->getBody();
    }
}