<?php
class Zftest_Service_Joindin
{
    const JOINDIN_API_BASE = 'http://joind.in/api';
    const JOINDIN_DEF_TYPE = 'xml';
    const JOINDIN_OUT_XML  = 'xml';
    const JOINDIN_OUT_JSON = 'json';
    
    /**
     * @var 	Zend_Http_Client A client to connect with Joind.in
     */
    protected $_client;
    /**
     * @var 	string The username to connect to Joind.in
     */
    protected $_username;
    /**
     * @var 	string The password to connect to Joind.in
     */
    protected $_password;
    /**
     * @var 	string The output type of request
     */
    protected $_output;
    /**
     * @var 	SimpleXMLElement
     */
    protected $_message;
    /**
     * @var 	Zftest_Service_Joindin_Site
     */
    protected $_site;
    /**
     * @var 	Zftest_Service_Joindin_Event
     */
    protected $_event;
    /**
     * @var 	Zftest_Service_Joindin_Talk
     */
    protected $_talk;
    /**
     * @var 	Zftest_Service_Joindin_User
     */
    protected $_user;
    /**
     * @var 	Zftest_Service_Joindin_Comment
     */
    protected $_comment;
    /**
     * Constructor for this joindin class
     * 
     * @param 	null|string $username 
     * @param 	null|string $password
     * @param 	string $output
     */
    public function __construct($username = null, $password = null, $output = self::JOINDIN_DEF_TYPE)
    {
        if (null !== $username) {
            $this->setUsername($username);
        }
        if (null !== $password) {
            $this->setPassword($password);
        }
        $this->setOutput($output);
        $this->setMessage(new SimpleXMLElement('<request></request>'));
        $this->_site = new Zftest_Service_Joindin_Site();
        $this->_event = new Zftest_Service_Joindin_Event();
        $this->_talk = new Zftest_Service_Joindin_Talk();
        $this->_user = new Zftest_Service_Joindin_User();
        $this->_comment = new Zftest_Service_Joindin_Comment();
    }
    /**
     * Sets the HTTP client
     * 
     * @param 	Zend_Http_Client $client
     * @return	Zftest_Service_Joindin
     */
    public function setClient(Zend_Http_Client $client)
    {
        $this->_client = $client;
        return $this;
    }
    /**
     * Retrieves the HTTP client
     * 
     * @return	Zend_Http_Client
     */
    public function getClient()
    {
        if (null === $this->_client) {
            $this->_client = new Zend_Http_Client();
        }
        return $this->_client;
    }
    /**
     * Sets the username for this joindin
     * 
     * @param 	string $username
     * @return	Zftest_Service_Joindin
     */
    public function setUsername($username)
    {
        $this->_username = (string) $username;
        return $this;
    }
    /**
     * Retrieves the username from this joindin class
     * 
     * @return	string
     */
    public function getUsername()
    {
        if (null === $this->_username) {
            throw new Zftest_Service_Joindin_Exception('Username is not set');
        }
        return $this->_username;
    }
    /**
     * Sets the password for this joindin account
     * 
     * @param 	string $password
     * @return	Zftest_Service_Joindin
     */
    public function setPassword($password)
    {
        $this->_password = (string) $password;
        return $this;
    }
    /**
     * Retrieves the password from this joindin account
     * 
     * @return	string
     */
    public function getPassword()
    {
        return $this->_password;
    }
    public function setOutput($output)
    {
        $types = array ('json', 'xml');
        if (!in_array($output, $types)) {
            $output = self::JOINDIN_DEF_TYPE;
        }
        $this->_output = (string) $output;
        return $this;
    }
    public function getOutput()
    {
        return $this->_output;
    }
    public function setMessage(SimpleXmlElement $message)
    {
        $this->_message = $message;
    }
    public function getMessage()
    {
        if (null === $this->_message) {
            throw new Zftest_Service_Joindin_Exception('Request message is not set');
        }
        return $this->_message;
    }
    public function user()
    {
        $this->_user->setJoindin($this);
        return $this->_user;
    }
    public function site()
    {
        $this->_site->setJoindin($this);
        return $this->_site;
    }
    public function connect(SimpleXMLElement $message, $apiEnd = null)
    {
        $this->getClient()
             ->setUri(self::JOINDIN_API_BASE . $apiEnd)
             ->setMethod(Zend_Http_Client::POST);
        if (self::JOINDIN_OUT_XML === $this->getOutput()) {
             $this->getClient()
                  ->setHeaders('Content-Type', 'text/xml')
                  ->setRawData($message->asXML());
        }
        $request = $this->getClient()->request();
        return $this->getClient()->getLastResponse();
    }
}